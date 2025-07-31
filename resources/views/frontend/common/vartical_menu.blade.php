
        <div class="side-menu animate-dropdown outer-bottom-xs">
          <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> Categories</div>
          <nav class="yamm megamenu-horizontal">
            <ul class="nav">



              @foreach($categories as $category)
              <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon {{ $category->category_icon }}" aria-hidden="true"></i>@if(session()->get('language') == 'ind') {{ $category->category_name_ind }} @else {{ $category->category_name_en }} @endif
              </a>
                <ul class="dropdown-menu mega-menu">
                  

                  <div class="yamm-content ">
                        <div class="row">

@php
  $subcategories = App\Models\SubCategory::where('category_id',$category->id)->orderBy('subcategory_name_en','ASC')->get();
@endphp
                        @foreach($subcategories as $subcategory)
                          <div class="col-xs-12 col-sm-6 col-md-2 col-menu">
                            <a href="{{ url('/category/product/'.$subcategory->id.'/'.$subcategory->subcategory_slug_en) }}">
                                <h2 class="title">
                                @if(session()->get('language') == 'ind') {{ $subcategory->subcategory_name_ind }} @else {{ $subcategory->subcategory_name_en }} @endif
                                </h2>
                              </a>
                            <ul class="links">
@php
  $subsubcategories = App\Models\SubSubCategory::where('subcategory_id',$subcategory->id)->orderBy('subsubcategory_name_en','ASC')->get();
@endphp 
                            @foreach($subsubcategories as $subsubcategory)
                              <li><a href="{{ url('/subsubcategory/product/'.$subsubcategory->id.'/'.$subsubcategory->subsubcategory_slug_en) }}">
                                @if(session()->get('language') == 'ind') {{ $subsubcategory->subsubcategory_name_ind }} @else {{ $subsubcategory->subsubcategory_name_en }}  @endif</a></li>
                            @endforeach
                            </ul>
                          </div>
                          @endforeach 
                          <!-- //end sub category foreach -->
                          <!-- /.col -->
                          
                          
                          {{-- <div class="col-xs-12 col-sm-6 col-md-4 col-menu banner-image"> <img class="img-responsive" src="{{ asset('frontend/assets/images/banners/top-menu-banner.jpg') }}" alt=""> </div> --}}
                          <!-- /.yamm-content --> 
                        </div>
                      </div>
                  <!-- /.yamm-content -->
                </ul>
                <!-- /.dropdown-menu --> 
              </li>
              @endforeach
              <!-- /.menu-item -->


              <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon fa fa-tree"></i>Environmentally</a> 
                <!-- /.dropdown-menu --> </li>
              <!-- /.menu-item -->
              
              <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon fa fa-leaf"></i>Recycling</a> 
                <!-- ================================== MEGAMENU VERTICAL ================================== --> 
                <!-- /.dropdown-menu --> 
                <!-- ================================== MEGAMENU VERTICAL ================================== --> </li>
              <!-- /.menu-item -->
              
              <li class="dropdown menu-item"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon fa fa-envira"></i>Home and Garden</a> 
                <!-- /.dropdown-menu --> </li>
              <!-- /.menu-item -->
              
            </ul>
            <!-- /.nav --> 
          </nav>
          <!-- /.megamenu-horizontal --> 
        </div>
        <!-- /.side-menu --> 