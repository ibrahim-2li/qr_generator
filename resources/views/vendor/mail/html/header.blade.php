@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-flex; align-items: center; gap: 10px;">
            @if (trim($slot) === 'Qr Generator')
                <div
                    style="width: 36px; height: 36px; background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 8px;">
                    <img src="{{ url('images/logo2.png') }}" alt="{{ config('app.name') }}"
                        style="width: 24px; height: 24px;">
                </div>
                <span style="color: #ffffff; font-size: 20px; font-weight: 700;">{{ config('app.name') }}</span>
            @else
                <div
                    style="width: 36px; height: 36px; background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 8px;">
                    <img src="{{ url('images/logo2.png') }}" alt="{{ config('app.name') }}"
                        style="width: 24px; height: 24px;">
                </div>
                <span style="color: #ffffff; font-size: 20px; font-weight: 700;">{!! $slot !!}</span>
            @endif
        </a>
    </td>
</tr>
