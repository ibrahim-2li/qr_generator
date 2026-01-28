<tr>
    <td>
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td class="content-cell" align="center" style="padding: 32px 24px;">
                    <p style="margin: 0 0 8px 0; color: #9ca3af; font-size: 13px;">
                        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </p>
                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                </td>
            </tr>
        </table>
    </td>
</tr>
