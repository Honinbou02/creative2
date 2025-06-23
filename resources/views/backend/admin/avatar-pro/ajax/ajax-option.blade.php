@forelse($voices as $voice)
    <option value="{{ $voice["voice_id"] }}" data-audio="{{ $voice["preview_audio"] }}">
        {{ $voice["name"] }} ({{ localize("Lang") }}:{{ $voice["language"] }} | {{ localize("Gender") }}:{{ $voice["gender"] }})
    </option>
@empty
@endforelse