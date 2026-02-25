<x-mail::message>
    # Congratulations, {{ $user->name }}!

    You have completed the course: **{{ $course->title }}**.

    We hope you enjoyed learning. Keep going and explore more courses!

    <x-mail::button :url="route('courses.show', $course)">
        View Course
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>