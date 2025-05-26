@component('mail::message')
# 👋 Hello {{ $data['name'] }},

Thanks for reaching out to us!

We’ve received your message and will get back to you as soon as possible.

---

**Your Message:**

{{ $data['message'] }}

---

If you need to follow up, feel free to reply to this email.

Thanks again,  
**{{ config('app.name') }} Team**
@endcomponent
