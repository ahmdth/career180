<div class="container mx-auto flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
    <div class="grid auto-rows-min gap-8 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($courses as $course)
        <div
            class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-4 flex flex-col">
            <flux:link href="{{ route('courses.show', $course) }}" class="absolute inset-0 z-10" />
            <div class="mb-3 h-60 w-full overflow-hidden rounded-md bg-zinc-50 dark:bg-zinc-800">
                <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="h-full w-full object-cover" />
            </div>

            <div class="flex-1 space-y-3">
                <flux:heading>{{ $course->title }}</flux:heading>
                <flux:badge size="sm" color="green">{{$course->level?->name}}</flux:badge>
                <flux:text class="line-clamp-2">{{ $course->description }}</flux:text>
            </div>
        </div>
        @endforeach
    </div>
    {{ $courses->links() }}
</div>