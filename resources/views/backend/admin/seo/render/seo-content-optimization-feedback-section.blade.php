
        <div class="tt-seo-report">
            <h5>{{ localize("Reports") }}</h5>
            <hr class="mb-3">
            <div class="row g-2">
                <div class="col-6 col-md-4">
                    <div class="border rounded p-3 d-flex flex-column h-100 text-center justify-content-center">
                        <div class="rounded-circle badge bg-soft-primary text-center mx-auto mb-1 fs-md" style="width: 22px; height: 22px;">{{ $reports["errors"] ?? 0 }}</div>
                        <span>{{ localize("Errors") }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="border rounded p-3 d-flex flex-column h-100 text-center justify-content-center">
                        <div class="rounded-circle badge bg-soft-warning text-center mx-auto mb-1 fs-md" style="width: 22px; height: 22px;">{{ $reports["warning"] ?? 0 }}</div>
                        <span>{{ localize("warning") }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="border rounded p-3 d-flex flex-column h-100 text-center justify-content-center">
                        <div class="rounded-circle badge bg-soft-success text-center mx-auto mb-1 fs-md" style="width: 22px; height: 22px;">
                            {{ $reports["optimized"] ?? 0 }}
                        </div>
                        <span>{{ localize("Optimized")}}</span>
                    </div>
                </div>
            </div>
        </div>

        @isset($feedbacks)
            @if(count($feedbacks))
                @php $loopNo = 1; @endphp

                @forelse($feedbacks as $feedbackTitle => $feedback)

                    @php
                        $feedBackId = "feedBackId{$loopNo}";
                        $currentLoop = $loopNo;
                        $loopNo++;
                    @endphp

                    <div class="accordion mt-3" id="{{ $feedBackId }}">
                        <div class="accordion-item border card shadow-none">
                            <h2 class="accordion-header">
                                <button type="button" class="accordion-button text-uppercase" data-bs-toggle="collapse" data-bs-target="#{{ $feedBackId }}-1" aria-expanded="false">
                                    {{ $feedbackTitle }} - <span class="text-{{ getSeoContentOptimizerScoreColor($feedback["score"]["percentage"]) }} ms-1"> Score: {{ number_format($feedback["score"]["seo_score"], 2) }}/{{ $feedback["score"]["max_score"] }}</span>
                                </button>
                            </h2>

                            <div id="{{ $feedBackId }}-1"
                                 class="accordion-collapse collapse {{ $currentLoop == 1 ? "show" : "" }}"
                                 data-bs-parent="#{{ $feedBackId }}">
                                @forelse($feedback["feedbacks"] as $feedbackSubTitle => $feedback1)
                                    <div class="accordion-body">
                                        <p class="mb-0">
                                            @if($feedback1["is_positive"])
                                                <span class="text-success fw-medium">
                                                    <i data-feather="check-circle" class="icon-14"></i>{{ $feedbackSubTitle }}:
                                                </span>
                                            @else
                                                <span class="text-danger fw-medium">
                                                    <i data-feather="x-circle" class="icon-14"></i>
                                                    {{ $feedbackSubTitle }}:
                                                </span>
                                            @endif
                                            {{ $feedback1["text"] }}
                                        </p>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            @endif
        @endisset

        <x-demo-seo-alert />
