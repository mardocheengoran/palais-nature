<nav class="navbar navbar-expand-lg">
    <button class="navbar-toggler side_navbar_toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSidetoggle" aria-expanded="false">
        <span class="ion-android-menu"></span>
    </button>
    <div class="pr_search_icon">
        <a href="javascript:void(0);" class="nav-link pr_search_trigger"><i class="linearicons-magnifier"></i></a>
    </div>
    <div class="collapse navbar-collapse mobile_side_menu" id="navbarSidetoggle">
        <ul class="navbar-nav">
            <li class="dropdown">
                <a class="{{-- dropdown-toggle --}} nav-link" href="#" data-bs-toggle="dropdown">
                    {{-- <span class="ion-android-menu"></span> --}}
                    <i class="icofont-navigation-menu" style="font-size: 30px;"></i>
                </a>
                <div class="dropdown-menu dropdown-reverse">
                    <ul>
                        @php($i = 0)
                        @foreach ($categories as $category)
                            @php($i++)
                            <li>
                                <a class="dropdown-item menu-link {{-- dropdown-toggler --}}" href="{{ route('article.index', $category->slug) }}">
                                    @if(!empty($category->getMedia('icon')->first()))
                                        <img src="{{ url($category->getMedia('icon')->first()->getUrl()) }}" style="width: 20px">
                                    @else
                                        <i class="{{ $category->icon }}"></i>
                                    @endif
                                    <span>{{ $category->title }}</span>
                                </a>
                                @if (count($category->childrens))
                                    <div class="dropdown-menu">
                                        <ul class="mega-menu d-lg-flex">
                                            @foreach ($category->childrens as $item)
                                                <li class="mega-menu-col col-lg-4">
                                                    <ul>
                                                        <li class="dropdown-header">
                                                            <a href="{{ route('article.index', $item->slug) }}">
                                                                {{ $item->title }}
                                                            </a>
                                                        </li>
                                                        @foreach ($item->childrens as $value)
                                                            <li>
                                                                <a class="py-1 dropdown-item nav-link nav_item" href="{{ route('article.index', $value->slug) }}">
                                                                    {{ $value->title }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                        {{-- <li>
                            <a class="dropdown-item menu-link dropdown-toggler" href="#">Masonry</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-three-columns.html">3 columns</a></li>
                                    <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-four-columns.html">4 columns</a></li>
                                    <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-left-sidebar.html">Left Sidebar</a></li>
                                    <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-right-sidebar.html">right Sidebar</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item menu-link dropdown-toggler" href="#">Single Post</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li><a class="dropdown-item nav-link nav_item" href="blog-single.html">Default</a></li>
                                    <li><a class="dropdown-item nav-link nav_item" href="blog-single-left-sidebar.html">left sidebar</a></li>
                                    <li><a class="dropdown-item nav-link nav_item" href="blog-single-slider.html">slider post</a></li>
                                    <li><a class="dropdown-item nav-link nav_item" href="blog-single-video.html">video post</a></li>
                                    <li><a class="dropdown-item nav-link nav_item" href="blog-single-audio.html">audio post</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item menu-link dropdown-toggler" href="#">List</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li><a class="dropdown-item nav-link nav_item" href="blog-list-left-sidebar.html">left sidebar</a></li>
                                    <li><a class="dropdown-item nav-link nav_item" href="blog-list-right-sidebar.html">right sidebar</a></li>
                                </ul>
                            </div>
                        </li> --}}
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
