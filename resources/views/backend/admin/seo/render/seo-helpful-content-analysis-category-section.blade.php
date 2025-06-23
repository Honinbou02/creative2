<div class="col-12 col-md-12">
    <div class="d-flex justify-content-between">
        <p class="mb-0">{{ localize("Content & Quality") }}</p>
        <span class="fw-medium">{{ $category_score["content and quality"]["score"] }}%</span>
    </div>
    <div class="progress w-100" style="height: 6px;">
        <div class="progress-bar bg-{{ getSeoContentOptimizerScoreColor($category_score["content and quality"]["score"]) }}" role="progressbar" style="width: {{ $category_score["content and quality"]["score"] }}%" aria-valuenow="{{ $category_score["content and quality"]["score"] }}" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>
<div class="col-12 col-md-12">
    <div class="d-flex justify-content-between">
        <p class="mb-0">{{ localize("Expertise") }}</p>
        <span class="fw-medium">{{ $category_score["expertise"]["score"] }}%</span>
    </div>
    <div class="progress w-100" style="height: 6px;">
        <div class="progress-bar bg-{{ getSeoContentOptimizerScoreColor($category_score["expertise"]["score"]) }}" role="progressbar" style="width: {{ $category_score["expertise"]["score"] }}%" aria-valuenow="{{ $category_score["expertise"]["score"] }}" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>
<div class="col-12 col-md-12">
    <div class="d-flex justify-content-between">
        <p class="mb-0">{{ localize("People-first Content") }}</p>
        <span class="fw-medium">{{ $category_score["people-first content"]["score"] }}%</span>
    </div>
    <div class="progress w-100" style="height: 6px;">
        <div class="progress-bar bg-{{ getSeoContentOptimizerScoreColor($category_score["people-first content"]["score"]) }}" role="progressbar" style="width: {{ $category_score["people-first content"]["score"] }}%" aria-valuenow="{{ $category_score["people-first content"]["score"] }}" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>