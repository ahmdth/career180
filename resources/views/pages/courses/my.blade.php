<div class="container mx-auto flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <h2 class="text-xl font-semibold">My Courses</h2>
    <div class="grid auto-rows-min gap-4 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($courses as $course)
            <div
                class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-4 flex flex-col">
                <flux:link href="{{ route('courses.show', $course) }}" class="absolute inset-0 z-10" />
                <div class="mb-3 h-40 w-full overflow-hidden rounded-md bg-zinc-50 dark:bg-zinc-800">
                    <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="h-full w-full object-cover" />
                </div>

                <div class="flex-1 space-y-3">
                    <flux:heading>{{ $course->title }}</flux:heading>
                    <flux:badge size="sm" color="green">{{$course->level?->name}}</flux:badge>
                    <flux:text class="line-clamp-2">{{ $course->description }}</flux:text>
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center gap-6 py-12">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-40 h-40 text-zinc-300">
                    <defs>
                        <linearGradient id="g" x1="0" x2="1">
                            <stop offset="0" stop-color="#a3a3a3" stop-opacity="0.15" />
                            <stop offset="1" stop-color="#737373" stop-opacity="0.08" />
                        </linearGradient>
                    </defs>
                    <rect x="6" y="18" width="52" height="34" rx="4" fill="url(#g)" />
                    <path d="M10 22h44v4H10z" fill="#e6e6e6" />
                    <path d="M14 30h36v2H14zM14 34h36v2H14zM14 38h36v2H14z" fill="#f3f4f6" />
                </svg>

                <flux:heading class="text-lg">You are not enrolled in any courses yet</flux:heading>
                <flux:text class="text-sm text-zinc-600 dark:text-zinc-400">Find a course to start learning — curated
                    lessons await.</flux:text>

                <flux:link href="{{ route('home') }}">
                    <flux:button variant="primary">Browse Courses</flux:button>
                </flux:link>
            </div>
        @endforelse
    </div>
</div>