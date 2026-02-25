<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2 flex flex-col gap-6">
        <div class="rounded-xl overflow-hidden bg-stone-100 border dark:border-black/20 dark:bg-black/40">
            <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="w-full h-64 object-cover" />
            <div class="p-6">
                <flux:heading size="xl">{{ $course->title }}</flux:heading>
                <flux:badge color="sky" size="sm" class="my-4">{{ $course->level->name }}</flux:badge>
                <flux:text class="text-neutral-700 dark:text-neutral-300 mb-6">{{ $course->description }}</flux:text>

                <div class="flex items-center gap-3">
                    @auth
                        @php
                            $enrolled = auth()->user()->courses()->where('course_id', $course->id)->exists();
                        @endphp

                        @if($enrolled)
                            <flux:button variant="primary" color="sky"
                                href="{{ route('lessons.show', ['course' => $course, 'lesson' => $course->lessons()->orderBy('order')->first()]) }}">
                                Continue</flux:button>
                        @else
                            <flux:button type="submit" wire:click="enroll" variant="primary" color="sky">Enroll</flux:button>
                        @endif
                    @else
                        <flux:button variant="primary" color="sky" href="{{ route('login') }}">Login to enroll</flux:button>
                    @endauth

                    <flux:button href="{{ route('home') }}" variant="subtle">Back to courses</flux:button>
                </div>
            </div>
        </div>

        <div class="rounded-xl p-8 bg-stone-100 border dark:border-black/20 dark:bg-black/40">
            <flux:heading size="lg" class="mb-3">Lessons</flux:heading>
            <ol class="space-x-2 space-y-4">
                @foreach ($lessons as $lesson)
                    <li class="bg-stone-100 dark:bg-neutral-800 p-3 rounded-lg">
                        <flux:link href="{{ route('lessons.show', ['course' => $course, 'lesson' => $lesson]) }}"
                            variant="subtle">
                            <div class="flex items-center space-x-2">
                                @if ($lesson->is_free_preview)
                                    <flux:icon.lock-open class="inline-block size-4" />
                                @else
                                    <flux:icon.lock-closed class="inline-block size-4" />
                                @endif
                                <span class="font-medium">{{ $lesson->title }}</span>
                                <time class="text-xs text-neutral-400">{{ $lesson->time() }}</time>
                            </div>
                        </flux:link>
                    </li>
                @endforeach
                @if($lessons->isEmpty())
                    <li class="text-neutral-500">No lessons yet.</li>
                @endif
            </ol>
        </div>
    </div>

    <aside class="self-start rounded-xl p-6 bg-stone-100 border dark:border-black/20 dark:bg-black/40">
        <h3 class="font-semibold mb-4">Course details</h3>
        <div class="text-sm space-y-4 dark:text-neutral-500 text-neutral-800">
            <div class="flex items-center justify-between">
                <span class="flex items-center gap-2">
                    <flux:icon.academic-cap />
                    <flux:text>Level</flux:text>
                </span>
                <flux:text>{{ $course->level?->name ?? '—' }}</flux:text>
            </div>
            <div class="flex items-center justify-between">
                <span class="flex items-center gap-2">
                    <flux:icon.user />
                    <flux:text>Students</flux:text>
                </span>
                <flux:text>{{ $course->enrollments()->count() }}</flux:text>
            </div>
            <div class="flex items-center justify-between">
                <span class="flex items-center gap-2">
                    <flux:icon.rectangle-stack />
                    <flux:text>Lessons</flux:text>
                </span>
                <flux:text>{{ $course->lessons()->count() }}</flux:text>
            </div>
            <div class="flex items-center justify-between">
                <span class="flex items-center gap-2">
                    <flux:icon.calendar-days />
                    <flux:text>Last update</flux:text>
                </span>
                <flux:text>{{ $course->created_at->format('F j, Y') }}</flux:text>
            </div>
            <div class="flex items-center justify-between">
                <span class="flex items-center gap-2">
                    <flux:icon.clock />
                    <flux:text>Run Time</flux:text>
                </span>
                <flux:text>{{ $course->time() }}</flux:text>
            </div>
        </div>
    </aside>
</div>