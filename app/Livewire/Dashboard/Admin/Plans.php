<?php

namespace App\Livewire\Dashboard\Admin;

use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Plans extends Component
{
    use WithPagination;

    public string $search = '';

    // Form fields
    public bool $showForm = false;

    public ?int $editingPlanId = null;

    public string $name = '';

    public string $description = '';

    public string $price = '';

    public string $interval = 'MONTHLY';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount(): void
    {
        $user = Auth::user();
        if (! $user || ! $user->isSuperAdmin()) {
            abort(403, 'Only super admins can access this page.');
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function createPlan(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function editPlan(int $id): void
    {
        $plan = Plan::findOrFail($id);
        $this->editingPlanId = $plan->id;
        $this->name = $plan->name;
        $this->description = $plan->description ?? '';
        $this->price = (string) $plan->price;
        $this->interval = $plan->interval;
        $this->showForm = true;
    }

    public function savePlan(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'interval' => 'required|in:MONTHLY,YEARLY',
        ]);

        if ($this->editingPlanId) {
            $plan = Plan::findOrFail($this->editingPlanId);
            $plan->update([
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'interval' => $this->interval,
            ]);
            session()->flash('success', 'Plan updated successfully.');
        } else {
            Plan::create([
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'interval' => $this->interval,
            ]);
            session()->flash('success', 'Plan created successfully.');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function cancelForm(): void
    {
        $this->resetForm();
        $this->showForm = false;
    }

    public function deletePlan(int $id): void
    {
        $plan = Plan::findOrFail($id);

        // Check if plan has subscriptions
        if ($plan->subscriptions()->exists()) {
            session()->flash('error', 'Cannot delete plan with existing subscriptions.');

            return;
        }

        $plan->delete();
        session()->flash('success', 'Plan deleted successfully.');
    }

    protected function resetForm(): void
    {
        $this->editingPlanId = null;
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->interval = 'MONTHLY';
        $this->resetErrorBag();
    }

    public function render()
    {
        $query = Plan::withCount('subscriptions');

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        $plans = $query->orderBy('price')->paginate(10);

        return view('livewire.dashboard.admin.plans', [
            'plans' => $plans,
        ])->layout('layouts.dashboard', ['title' => __('dashboard.manage_plans')]);
    }
}
