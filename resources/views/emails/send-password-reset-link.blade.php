<x-mail::message>
# Hi User,

You are receiving this email because we received a password reset request for your account.

<x-mail::button :url="$link">
Reset Password
</x-mail::button>

If you did not request a password reset, no further action is required.

Thanks,<br>
{{ config('app.name') }}

<hr>

<small>
    If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser: <a href="{{ $link }}">{{ $link }}</a>
</small>
</x-mail::message>
