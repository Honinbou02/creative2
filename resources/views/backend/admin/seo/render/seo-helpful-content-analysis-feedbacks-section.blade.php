<div class="accordion mt-3" id="seoAccordionParent">
    @isset($detailed_ratings)
        @if(count($detailed_ratings))
            @php $loopNo = 0; @endphp

            @forelse($detailed_ratings as $categoryname => $questions)
                @php
                    $loopNo++;
                    $feedBackId = "feedBackId{$loopNo}"; // feedback1
                @endphp
                    <div class="accordion-item border card shadow-none">
                        <h2 class="accordion-header">
                            <button type="button" 
                                    class="accordion-button text-uppercase {{ $loopNo == 1 ? " " : "collapsed" }}" 
                                    data-bs-toggle="collapse"
                                    data-bs-target="#{{ $feedBackId }}" 
                                    aria-expanded="false" 
                                    aria-controls="{{ $feedBackId }}" >
                                {{ $categoryname }} - <span class="text-{{ getSeoContentOptimizerScoreColor($category_score[$categoryname]["score"]) }} ms-1"> Score: {{ number_format($category_score[$categoryname]["earned points"], 2) }} /{{ $category_score[$categoryname]["available points"] }}</span>
                            </button>
                        </h2>

                        <div id="{{ $feedBackId }}"
                                class="accordion-collapse collapse {{ $loopNo == 1 ? "show" : "" }}"
                                data-bs-parent="#seoAccordionParent">
                                @if (count($questions))
                                @php $questionCounter = 1; @endphp
                                @foreach ($questions as $question => $feedbackRating)
                                    <div class="accordion-body">
                                        <h6>{{ $questionCounter }}. {{ $question }}</h6>
                                        <p class="text-muted">
                                            {{ $feedbackRating["feedback"] }}
                                            <span class="text-warning fw-medium">[Rating: {{ $feedbackRating["rating"] }}]</span>
                                        </p>
                                    </div>
                                    @php $questionCounter++; @endphp
                                @endforeach                                    
                            @endif
                        </div>
                    </div>
                
            @endforeach
        @endif
    @endisset
</div>

<x-demo-seo-alert />
