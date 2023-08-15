<x-app-layout>
    <div class="row mb-4">
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="p-2 bg-white p-3 mb-3 shadow-sm">
                <div class="row">
                    <div class="col-8">
                        <div class="header-pretitle text-muted fs-11 fw-bold text-uppercase mb-2">
                            Total Article
                        </div>
                        <h2 class="fs-26 fw-bold">40,689</h2>
                        <p>(Current Month)</p>
                    </div>
                    <div class="col-4 d-flex align-items-center">
                        <img src="assets/dist/img/total-article-icon.png" alt="">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="p-2 bg-white p-3 mb-3 shadow-sm">
                <div class="row">
                    <div class="col-8">
                        <div class="header-pretitle text-muted fs-11 fw-bold text-uppercase mb-2">
                            Total Image Generate
                        </div>
                        <h2 class="fs-26 fw-bold">10,689</h2>
                        <p>(Current Month)</p>
                    </div>
                    <div class="col-4 d-flex align-items-center">
                        <img src="assets/dist/img/image-generate-icon.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="p-2 bg-white p-3 mb-3 shadow-sm">
                <div class="row">
                    <div class="col-8">
                        <div class="header-pretitle text-muted fs-11 fw-bold text-uppercase mb-2">
                            Total FAQ Generate
                        </div>
                        <h2 class="fs-26 fw-bold">689</h2>
                        <p>(Current Month)</p>
                    </div>
                    <div class="col-4 d-flex align-items-center">
                        <img src="assets/dist/img/faq-icon.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="p-2 bg-white p-3 mb-3 shadow-sm">
                <div class="row">
                    <div class="col-8">
                        <div class="header-pretitle text-muted fs-11 fw-bold text-uppercase mb-2">
                            Total SEO Checker
                        </div>
                        <h2 class="fs-26 fw-bold">20,689</h2>
                        <p>(Current Month)</p>
                    </div>
                    <div class="col-4 d-flex align-items-center">
                        <img src="assets/dist/img/seo-checker.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-xl-6">
        <div class="card mb-4">
            <div class="card-body text-center">
                <div class="row justify-content-center">
                    <div class="greet-user col-12 col-xl-10">
                        <h2 class="fs-23 font-weight-600 mb-2">
                            Welcome @auth
                                {{ auth()->user()->name }}
                            @endauth,
                        </h2>
                        @if (auth()->user()->membership_notification == null || auth()->user()->membership_notification == 0)
                            <p class="text-muted">
                                {{ $checkFreeUser ? 'You are enjoying the free version of the tool. Upgrade to the premium version to get access to all the features.' : 'You are enjoying the premium version of the tool.' }}
                            </p>
                            <a href="#!" class="btn btn-success btnChangeMembership">
                                {{ $checkFreeUser ? 'Upgrade to premium' : 'Switch to free version' }}
                            </a>
                        @elseif (auth()->user()->membership_notification == 1)
                            <p class="text-muted">
                                You have submitted a request. Please wait for admin approval.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            $(document).ready(function() {
                $('.btnChangeMembership').click(function() {
                    $.ajax({
                        url: "{{ route('posts.change-membership') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.message != null) {
                                toastr.success(response.message, "Success");
                                location.reload();
                            }
                        }
                    })
                })
            })
        </script>
    @endpush

</x-app-layout>
