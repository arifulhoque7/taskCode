<x-front-layout>
    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row d-flex">
                <div class="col-xl-8 py-5 px-md-5">
                    <div class="row pt-md-4">
                        @foreach ($allPosts as $post)
                            <div class="col-md-12">
                                <div class="blog-entry ftco-animate d-md-flex">
                                    <a href="#" class="img img-2"
                                        style="background-image: url({{ front_asset('images/image_'.mt_rand(1, 12).'.jpg') }});"></a>
                                    <div class="text text-2 pl-md-4">
                                        <h3 class="mb-2">{{ $post->title }}</h3>
                                        <div class="meta-wrap">
                                            <p class="meta">
                                                <span><i class="icon-calendar mr-2"></i>{{ \Carbon\Carbon::parse($post->publish_time)->format('Y-m-d H:i:s') }}</span>
                                            </p>
                                        </div>
                                        <p class="mb-4">{{ $post->description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="block-27">
                                {{ $allPosts->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 sidebar ftco-animate bg-light pt-5">
                    <div class="sidebar-box pt-md-4">
                        <form action="#" class="search-form">
                            <div class="form-group">
                                <span class="icon icon-search"></span>
                                <input type="text" class="form-control" placeholder="Type a keyword and hit enter">
                            </div>
                        </form>
                    </div>
                    <div class="sidebar-box ftco-animate">
                        <h3 class="sidebar-heading">Categories</h3>
                        <ul class="categories">
                            <li><a href="#">Fashion <span>(6)</span></a></li>
                            <li><a href="#">Technology <span>(8)</span></a></li>
                            <li><a href="#">Travel <span>(2)</span></a></li>
                            <li><a href="#">Food <span>(2)</span></a></li>
                            <li><a href="#">Photography <span>(7)</span></a></li>
                        </ul>
                    </div>


                    <div class="sidebar-box ftco-animate">
                        <h3 class="sidebar-heading">Archives</h3>
                        <ul class="categories">
                            <li><a href="#">Decob14 2018 <span>(10)</span></a></li>
                            <li><a href="#">September 2018 <span>(6)</span></a></li>
                            <li><a href="#">August 2018 <span>(8)</span></a></li>
                            <li><a href="#">July 2018 <span>(2)</span></a></li>
                            <li><a href="#">June 2018 <span>(7)</span></a></li>
                            <li><a href="#">May 2018 <span>(5)</span></a></li>
                        </ul>
                    </div>
                    <div class="sidebar-box ftco-animate">
                        <h3 class="sidebar-heading">Paragraph</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus itaque, autem
                            necessitatibus voluptate quod mollitia delectus aut.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-front-layout>
