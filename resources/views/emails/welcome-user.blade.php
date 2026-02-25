@component('mail::message')
# Welcome, {{ $user->name }} 🎉

Thanks for registering at **Career 180 LMS**!

You can now explore our courses, watch lessons, and track your learning progress.

@component('mail::button', ['url' => url('/')])
Go to Dashboard
@endcomponent

Happy learning!
**The Career 180 Team**
@endcomponent
