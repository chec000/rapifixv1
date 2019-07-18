<?php echo PageBuilder::section('head', [
    'categories' => $categories,
    'cart'=>$cart
]); ?>




<section class="shop-content mt-40 mb-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 order-2 order-lg-1">
                <div class="shoppage-sidebar">
                    <!-- category list -->
                    <!-- Header Category -->
                    <div class="hero-side-category shop-side-category">

                        <h2 class="block-title">CATEGORIES</h2>

                        <!-- Category Menu -->
                        <nav class="shop-category-menu mb-50">
                            <ul>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e(route('category.products', ['id' => $c->id])); ?>"><?php echo e($c['name']); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </ul>
                        </nav>
                        <!-- end of Category menu -->
                    </div>
                    <!-- End of Header Category -->
                    <!-- end of category list -->



                    <!-- oue store widget -->
                    <div class="sidebar">
                        <div class="store-container mb-50">
                            <h2 class="block-title">OUR Stores</h2>
                            <div class="store-widget-container">
                                <div class="store-image mb-20">
                                    <a href="store.html"> <img src="assets/images/store.jpg" alt="" class="img-fluid"></a>
                                </div>
                            </div>
                            <a href="store.html" class="store-btn">Discover our store <i class="fa fa-chevron-right"></i></a>
                        </div>
                    </div>
                    <!-- end of oue store widget -->

                    <!-- tag container -->
                    <div class="sidebar">
                        <h2 class="block-title">TAGS</h2>
                        <div class="tag-container">

                            <ul>
                                <li><a href="shop-left-sidebar.html">new</a> </li>
                                <li><a href="shop-left-sidebar.html">bags</a> </li>
                                <li><a href="shop-left-sidebar.html">new</a> </li>
                                <li><a href="shop-left-sidebar.html">kids</a> </li>
                                <li><a href="shop-left-sidebar.html">fashion</a> </li>
                                <li><a href="shop-left-sidebar.html">Accessories</a> </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end of tag container -->


                </div>
            </div>
            <div class="col-lg-9 col-md-8  order-1 order-lg-2">
                <div class="shop-page-container">
                    <div class="shop-page-header">
                        <div class="row">
                            <div class="col-12">
                                <h2><?php echo e($category->name); ?></h2>
                            </div>
                            <div class="col-lg-4 col-sm-12 d-flex justify-content-start align-items-center">
                                <!-- Product view mode -->
                                <p class="view-mode">View:</p>
                                <div class="view-mode-icons">
                                    <a class="active" href="#" data-target="grid"><i class="fa fa-th"></i> <span>Grid</span></a>
                                    <a href="#" data-target="list"><i class="fa fa-list"></i><span>List</span></a>
                                </div>
                            </div>
                            <div class="col-lg-8 col-sm-12 d-flex flex-column flex-sm-row justify-content-lg-end justify-content-start">
                                <!-- Product Showing -->
                                <div class="product-showing mr-20 mb-sm-10">
                                    <p>Show
                                        <select name="showing">
                                            <option value="1">8</option>
                                            <option value="2">12</option>
                                            <option value="3">16</option>
                                            <option value="4">20</option>
                                            <option value="5">24</option>
                                        </select>
                                        <span>per page</span>
                                    </p>
                                </div>

                                <!-- Product Short -->
                                <div class="product-sort">
                                    <p>Sort by
                                        <select name="sortby">
                                            <option value="trending">Trending items</option>
                                            <option value="sales">Best sellers</option>
                                            <option value="rating">Best rated</option>
                                            <option value="date">Newest items</option>
                                            <option value="price-asc">Price: low to high</option>
                                            <option value="price-desc">Price: high to low</option>
                                        </select>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="shop-product-wrap grid row">
                        <!-- ======  Shop product list  ====== -->
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12 pb-30 pt-10">
                            <!-- product start -->
                            <div class="single-product shop-page-product single-grid-product new-badge sale-badge">
                                <div class="single-product-content">
                                    <div class="product-image">
                                        
                                <a href="<?php echo e(route('products.detail', ['product_slug' => $p->slug])); ?>" >

                        <img src="<?php echo e($p->image); ?>" class="img-fluid" alt="">
                                        </a>
                                        <div class="image-btn">
                                            <a href="#" data-toggle="modal" data-target="#quick-view-modal-container"><i class="fa fa-search"></i></a>
                                            <a href="#"><i class="fa fa-refresh"></i></a>
                                            <a href="#"><i class="fa fa-heart-o"></i></a>
                                        </div>
                                    </div>
                                    <h5 class="product-name"><a href="single-product-variable.html"><?php echo e($p->name); ?></a></h5>
                                    <div class="price-box">
                                        <h4><?php echo e($p->price); ?></h4>
                                    </div>
                                    <span onclick="ShoppingCart.add('<?php echo e($p->id); ?>', 1)" class="add-to-cart-btn">
                                <i class="fa fa-shopping-cart"></i>
                                Add to Cart
                            </span>
                                        <!--
                                    <a href="#" class="add-to-cart-btn" data-toggle="modal" data-target="#add-to-cart-modal-container"><i class="fa fa-shopping-cart"></i> Add to Cart</a>-->
                                </div>
                            </div>
                            <!-- product end -->

                            <!-- product list start -->
                            <div class="single-list-product">
                                <div class="list-product-image new-badge sale-badge">
                                      <a href="<?php echo e(route('products.detail', ['product_slug' => $p->slug])); ?>" >

                                        <img src="<?php echo e($p['image']); ?>" class="img-fluid" alt="">
                                    </a>
                                    <div class="image-btn">
                                        <a href="#" data-toggle="modal" data-target="#quick-view-modal-container"><i class="fa fa-search"></i></a>
                                        <a href="#"><i class="fa fa-refresh"></i></a>
                                        <a href="#"><i class="fa fa-heart-o"></i></a>
                                    </div>
                                </div>

                                <div class="list-product-desc">
                                    <h5 class="product-name">
                                        <a href="single-product-variable.html"><?php echo e($p['name']); ?></a></h5>
                                    <div class="price-box">
                                        <h4><?php echo e($p['price']); ?></h4>
                                    </div>
                                    <p class="product-description">
                                        <?php echo e($p['description']); ?>

                                    </p>
                                    <p class="color">
                                        <a href="#"><span class="color-block color-choice-1"></span></a>
                                        <a href="#"><span class="color-block color-choice-2"></span></a>
                                        <a href="#"><span class="color-block color-choice-3 active"></span></a>
                                    </p>
                                    <p class="stock-status"><span class="stock-status in-stock">In Stock</span></p>

                                    <span onclick="ShoppingCart.add('<?php echo e($p->id); ?>', 1)" class="add-to-cart-btn">
                                <i class="fa fa-shopping-cart"></i>
                                Add to Cart
                            </span>
                                    <a href="#" class="add-to-cart-btn" data-toggle="modal" data-target="#add-to-cart-modal-container"><i class="fa fa-shopping-cart"></i>
                                        Add to Cart</a>
                                </div>
                            </div>
                            <!-- product list end -->
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <!-- ====  End of Shop product list  ==== -->

                    </div>

                    <!-- product pagination -->

                    <div class="shop-page-pagination-section d-flex justify-content-between align-items-center">
                        <div class="search-result">
                            Showing 1 - 6 of 9 items
                        </div>
                                         <div id="product_pagination" class="pagination-container">
    

    <?php if($products->hasPages()): ?>
    <ul class="pagination justify-content-left justify-content-lg-center">
        <?php if($products->onFirstPage()): ?>
            <li style="display: none;"  class="disabled"><span>? Previous</span></li>
        <?php else: ?>
        <li  class="previous disabled"><a aria-disabled="true" href="<?php echo e($products->previousPageUrl()); ?>"><i class="fa fa-angle-left"></i>Back</a></li>  
        <?php endif; ?>
      
        <?php for($i=1;$i<=$products->lastPage();$i++): ?>
        <?php if($i==$products->currentPage()): ?>

        <li class="disabled">
            <a  rel="next">
        <?php echo e($i); ?>

            </a></li>
        <?php else: ?>
            <li>
            <a href="<?php echo e($products->url($i)); ?>" rel="next">
<?php echo e($i); ?>

</a></li> 
       <?php endif; ?>

        <?php endfor; ?>
        <!-- Array Of Links -->
       
        <?php if($products->hasMorePages()): ?>
            <li class="next"><a href="<?php echo e($products->nextPageUrl()); ?>" rel="next">
            Next
            <i class="fa fa-angle-right"></i>
            </a>    
        </li>
 
        <?php endif; ?>
    
    </ul>
<?php endif; ?>

</div>  


                        <div class="pagination-buttons">
                            <a href="#" class="show-all-btn">Show all</a>
                            <a href="compare.html" class="compare-btn">Compare (0) <i class="fa fa-angle-right"></i></a>
                        </div>

                    </div>

                    <!-- end of product pagination -->
                

                </div>
            </div>
        </div>
    </div>
</section>

<?php echo PageBuilder::section('footer',['categories'=>$categories]); ?>

