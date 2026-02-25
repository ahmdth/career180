<div x-data="videoPlayer({{ $progress ?? 0 }})" x-init="initPlayer()" {{ $attributes->merge(['class' => "mx-auto space-y-4"]) }}>
    <div class="aspect-video rounded-xl overflow-hidden shadow-lg">
        <video x-ref="video" controls class="w-full h-full rounded-lg">
            <source src="{{ $lesson->video_url }}" type="video/mp4" />
        </video>
    </div>
</div>