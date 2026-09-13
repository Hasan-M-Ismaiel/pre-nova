<!-- Contact Section Start (Replaces Newsletter) -->
<div id="contact" class="container-fluid bg-primary newsletter p-0">
    <div class="container-fluid p-0">
        <div class="row g-0 align-items-stretch">

            <!-- Left Side: Full-Height Image -->
            <div class="col-md-5 wow fadeIn" data-wow-delay="0.2s" style="overflow: hidden;">
                <img
                    src="{{ asset('assets/img/newsletter.png') }}"
                    alt="Contact Image"
                    class="img-fluid w-100 h-100"
                    style="object-fit: cover; object-position: center; min-height: 100%;">
            </div>

            <!-- Right Side: Contact Form -->
            <div class="col-md-7 d-flex align-items-center bg-light wow fadeIn" data-wow-delay="0.5s">
                <div class="p-5 w-100">
                    <h1 class="mb-5 text-center">
                        Have Any Query?
                        <span class="text-uppercase text-primary bg-light px-2">Contact Us</span>
                    </h1>
                    <p class="text-center mb-4 text-muted">
                        Whether you’re building your digital brand, or looking for creative guidance -
                        let’s talk. You’ll connect directly with <strong>Hasan</strong> and the
                        <strong>novALight</strong> team with less than 6 hours and They will handle it from there bring your ideas to life.
                    </p>


                    <!-- Validation Errors -->
                    @if ($errors->any())
                    <div class="mb-4 mt-4" id="signUpForm">
                        <span class="pe-4 font-medium text-danger border border-danger border-rounded rounded">
                            <span class="bg-danger py-2 px-2  text-white">Whoops!</span>{{ __(' Something went wrong.') }}
                        </span>

                        <ul class="mt-3 list-group list-group-flush text-danger">
                            @foreach ($errors->all() as $error)
                            <li class="list-group-item text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action='{{ route("storeContact") }}' method="POST" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                                    <label for="name">Your Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Your Email" required>
                                    <label for="email">Your Email</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" name="subject" class="form-control" id="subject" placeholder="Subject">
                                    <label for="subject">Subject</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea name="message" class="form-control" placeholder="Leave a message here" id="message" style="height: 150px"></textarea>
                                    <label for="message">Message</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Contact Section End -->