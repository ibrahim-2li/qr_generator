# Filament 4 to Livewire 4 Migration Checklist (File-by-File)

## Scope
- Goal: remove Filament admin UI and rebuild dashboard/admin on plain Livewire 4.
- Current state: Filament 4 app with Livewire 3 and heavy Filament coupling in `app/Filament/**`.
- Keep business logic and models unchanged where possible; migrate UI and routing surfaces first.

## Phase 0: Safety Baseline (before code moves)

- [x] `tests/Feature/ExampleTest.php` -> replaced with SmokeTest.php for `/`, `/dashboard`, auth redirects.
- [x] `tests/Unit/ExampleTest.php` -> replaced with SubscriptionTrialTest.php for subscription/trial logic.
- [x] `tests/TestCase.php` -> added shared helpers/factories setup for authenticated user roles (`USER`, `ADMIN`, `SUPER_ADMIN`).

## Phase 1: Platform and Dependency Cutover

- [ ] `composer.json`  
  Remove `filament/*` and `joaopaulolndev/filament-edit-profile`.  
  Add/upgrade `livewire/livewire:^4.1`.  
  Remove `@php artisan filament:upgrade` script entry.
  **Note: Pending - need to keep Filament running during transition phase**

- [ ] `bootstrap/providers.php`  
  Remove `App\Providers\Filament\DashboardPanelProvider::class` after new dashboard routes/components are in place.
  **Note: Pending - Filament still needed for analytics/QR/admin pages**

- [ ] `app/Providers/Filament/DashboardPanelProvider.php`  
  Decommission and delete after route and middleware replacement is complete.
  **Note: Pending**

- [x] `app/Models/User.php`  
  Removed Filament-specific contract and methods:
  - `implements FilamentUser`
  - `canAccessPanel(...)`
  - `canAccess(...)` (Filament table layout type)  
  Kept role and subscription helpers.

- [ ] `config/filament-edit-profile.php`  
  Replace usage with app-local profile settings (or move key needed by `getFilamentAvatarUrl()` to a new config).
  **Note: Pending - getAvatarUrl method added as replacement**

## Phase 2: New Dashboard Route Surface (Livewire 4)

- [x] `routes/web.php`  
  Added new authenticated route group for Livewire dashboard pages (billing, subscription, home).  
  Added temporary backward compatibility aliases for old route names.

- [x] `app/Http/Controllers/PaymentController.php`  
  Replaced all `filament.dashboard.*` redirects with new Livewire dashboard route names.

- [x] `app/Http/Controllers/PaymentFormController.php`  
  Replaced fallback redirect route `filament.dashboard.pages.subscribe-page`.

- [ ] `resources/views/payment/form.blade.php`  
  Replace `filament.dashboard.pages.subscribe-page` and `filament.dashboard.pages.my-subscription-page` links.
  **Note: Check if file exists**

- [x] `resources/views/qr/expired.blade.php`  
  Replaced `filament.dashboard.pages.subscribe-page` link.

## Phase 3: Billing Pages (highest risk first)

- [x] `app/Filament/Pages/SubscribePage.php` -> migrated to `app/Livewire/Dashboard/Billing/SubscribePage.php`.
- [x] `resources/views/filament/pages/subscribe-page.blade.php` -> migrated to `resources/views/livewire/dashboard/billing/subscribe-page.blade.php`.

- [x] `app/Filament/Pages/MySubscriptionPage.php` -> migrated to `app/Livewire/Dashboard/Billing/MySubscriptionPage.php`.
- [x] `resources/views/filament/pages/my-subscription-page.blade.php` -> migrated to `resources/views/livewire/dashboard/billing/my-subscription-page.blade.php`.

- [x] `app/Filament/Pages/PaymentPage.php` -> migrated to `app/Livewire/Dashboard/Billing/PaymentPage.php`.
- [x] `resources/views/filament/pages/payment-page.blade.php` -> migrated to `resources/views/livewire/dashboard/billing/payment-page.blade.php`.

- [ ] `resources/views/filament/pages/analytics-dashboard.blade.php`  
  Remove or merge into new dashboard home page once analytics page is rebuilt.

## Phase 4: Analytics Migration (widgets + filters)

- [x] `app/Filament/Pages/Analytics.php` -> migrated to `app/Livewire/Dashboard/Analytics.php`.
- [x] `resources/views/filament/pages/analytics.blade.php` -> migrated to `resources/views/livewire/dashboard/analytics.blade.php`.

- [x] Analytics widgets migrated inline into Analytics Livewire component:
  - QrCodeStatsWidget -> Stats cards in Analytics component
  - ScansByCountryChart -> Bar chart in Analytics component
  - ScansByDeviceChart -> Bar chart in Analytics component
  - ScansByOsChart -> Bar chart in Analytics component
  - ScanTrendsChart -> Trend chart in Analytics component

## Phase 5: QR Code Module (largest custom resource) ✅ COMPLETED

- [x] `app/Filament/Resources/QrCodes/QrCodeResource.php`  
  Migrated role-aware query scoping and infolist logic into Livewire components.

- [x] `app/Filament/Resources/QrCodes/Pages/ListQrCodes.php` -> `app/Livewire/Dashboard/QrCodes/Index.php`.
- [x] `app/Filament/Resources/QrCodes/Pages/CreateQrCode.php` -> `app/Livewire/Dashboard/QrCodes/Create.php` with subscription gate.
- [x] `app/Filament/Resources/QrCodes/Pages/EditQrCode.php` -> `app/Livewire/Dashboard/QrCodes/Edit.php` with file upload.
- [x] `app/Filament/Resources/QrCodes/Pages/ViewQrCode.php` -> `app/Livewire/Dashboard/QrCodes/View.php`.

- [x] `app/Filament/Resources/QrCodes/Schemas/QrCodeForm.php`  
  Converted field definitions to Livewire form properties in Create/Edit components.

- [x] `app/Filament/Resources/QrCodes/Tables/QrCodesTable.php`  
  Converted table columns/actions/search/sort to Livewire Index component.

## Phase 6: Admin CRUD Modules ✅ COMPLETED

### Users ✅
- [x] `app/Filament/Resources/Users/UserResource.php` -> `app/Livewire/Dashboard/Admin/Users.php`
  Full CRUD with search, filter, and delete.

### Plans ✅
- [x] `app/Filament/Resources/Plans/PlanResource.php` -> `app/Livewire/Dashboard/Admin/Plans.php`
  Full CRUD with inline create/edit form.

### Subscriptions ✅
- [x] `app/Filament/Resources/Subscriptions/SubscriptionResource.php` -> `app/Livewire/Dashboard/Admin/Subscriptions.php`
  List with status filtering and inline status updates.

### Payments ✅
- [x] `app/Filament/Resources/Payments/PaymentResource.php` -> `app/Livewire/Dashboard/Admin/Payments.php`
  Read-only list with search and status filtering.

### Partners
- [ ] `app/Filament/Resources/Partners/PartnerResource.php`
- [ ] `app/Filament/Resources/Partners/Pages/ListPartners.php`
- [ ] `app/Filament/Resources/Partners/Pages/CreatePartner.php`
- [ ] `app/Filament/Resources/Partners/Pages/EditPartner.php`
- [ ] `app/Filament/Resources/Partners/Schemas/PartnerForm.php`
- [ ] `app/Filament/Resources/Partners/Tables/PartnersTable.php`

### FAQs
- [ ] `app/Filament/Resources/Faqs/FaqResource.php`
- [ ] `app/Filament/Resources/Faqs/Pages/ListFaqs.php`
- [ ] `app/Filament/Resources/Faqs/Pages/CreateFaq.php`
- [ ] `app/Filament/Resources/Faqs/Pages/EditFaq.php`
- [ ] `app/Filament/Resources/Faqs/Schemas/FaqForm.php`
- [ ] `app/Filament/Resources/Faqs/Tables/FaqsTable.php`

### Contacts
- [ ] `app/Filament/Resources/Contacts/ContactResource.php`
- [ ] `app/Filament/Resources/Contacts/Pages/ListContacts.php`
- [ ] `app/Filament/Resources/Contacts/Pages/CreateContact.php`
- [ ] `app/Filament/Resources/Contacts/Pages/ViewContact.php`
- [ ] `app/Filament/Resources/Contacts/Schemas/ContactForm.php`
- [ ] `app/Filament/Resources/Contacts/Schemas/ContactInfolist.php`
- [ ] `app/Filament/Resources/Contacts/Tables/ContactsTable.php`

## Phase 7: Profile and Auth Pages (Filament plugin removal) ✅ COMPLETED

- [x] `app/Livewire/Dashboard/Profile.php` - Native Livewire profile page with:
  - Profile information update (name, email, avatar)
  - Password change functionality
  - Account information display

- [x] All Filament edit-profile overrides can now be removed (pending Phase 8 cleanup).

## Phase 8: Final Cleanup and Hard Delete

- [ ] `app/Filament/**` directory -> delete after all replacements and tests pass.
- [ ] `resources/views/filament/**` directory -> delete after all replacements and tests pass.
- [ ] `app/Providers/Filament/**` directory -> delete after provider removal in bootstrap.
- [ ] `public/js/filament/**` and `public/css/filament/**` -> clear generated Filament assets.
- [ ] `public/fonts/filament/**` -> remove if unused by new UI.

## Route-Name Checklist (must be zero old references before release)

- [ ] `app/Http/Controllers/PaymentController.php` old names removed.
- [ ] `app/Http/Controllers/PaymentFormController.php` old names removed.
- [ ] `resources/views/payment/form.blade.php` old names removed.
- [ ] `resources/views/qr/expired.blade.php` old names removed.
- [ ] `app/Filament/Resources/QrCodes/Pages/CreateQrCode.php` old names removed (then file deleted in cleanup).

## Acceptance Gates

- [ ] `php artisan route:list` shows no `filament.dashboard.*` routes.
- [ ] `rg -n "filament\\.dashboard|use Filament\\\\|<x-filament|filament-edit-profile" app bootstrap config resources routes` returns no actionable hits.
- [ ] Billing flow works end-to-end (plan selection -> Moyasar redirect -> callback -> subscription activation).
- [ ] QR create/edit/view/list works for USER and ADMIN roles.
- [ ] Analytics page loads with filters and all charts.
- [ ] Full test suite passes.
