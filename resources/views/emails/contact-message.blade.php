@component('mail::message')
# 📬 You've Received a New Contact Message

**Name:** {{ $data['name'] }}  
**Phone:** {{ $data['phone'] }}  
@if(!empty($data['email']))
**Email:** {{ $data['email'] }}
@endif

---

**Message:**

{{ $data['message'] }}

@component('mail::button', ['url' => 'mailto:' . ($data['email'] ?? '')])
Reply via Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent