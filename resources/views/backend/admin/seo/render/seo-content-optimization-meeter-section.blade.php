<div class="col-12 col-md-6">
    <div class="d-flex justify-content-between">
        <p class="mb-0">{{ localize("Title") }}</p>
        <span class="fw-medium">{{ $overview["title"] }}%</span>
    </div>
    <div class="progress w-100" style="height: 6px;">
        <div class="progress-bar bg-{{ getSeoContentOptimizerScoreColor($overview["title"]) }}" role="progressbar" style="width: {{ $overview["title"] }}%" aria-valuenow="{{ $overview["title"] }}" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="d-flex justify-content-between">
        <p class="mb-0">{{ localize("Heading") }}</p>
        <span class="fw-medium">{{ $overview["heading"] }}%</span>
    </div>
    <div class="progress w-100" style="height: 6px;">
        <div class="progress-bar bg-{{ getSeoContentOptimizerScoreColor($overview["heading"]) }}" role="progressbar" style="width: {{ $overview["heading"] }}%" aria-valuenow="{{ $overview["heading"] }}" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="d-flex justify-content-between">
        <p class="mb-0">{{ localize("Terms") }}</p>
        <span class="fw-medium">{{ $overview["terms"] }}%</span>
    </div>
    <div class="progress w-100" style="height: 6px;">
        <div class="progress-bar bg-{{ getSeoContentOptimizerScoreColor($overview["terms"]) }}" role="progressbar" style="width: {{ $overview["terms"] }}%" aria-valuenow="{{ $overview["terms"] }}" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>
<div class="col-12 col-md-6">
    <div class="d-flex justify-content-between">
        <p class="mb-0">{{ localize("Word") }}</p>
        <span class="fw-medium">{{ $overview["word"] }}%</span>
    </div>
    <div class="progress w-100" style="height: 6px;">
        <div class="progress-bar bg-{{ getSeoContentOptimizerScoreColor($overview["word"]) }}" role="progressbar" style="width: {{ $overview["word"] }}%" aria-valuenow="{{ $overview["word"] }}" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>