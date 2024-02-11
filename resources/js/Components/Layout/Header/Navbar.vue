<script setup>

</script>


<template>
    <nav class="navbar navbar-expand-lg banner-bg-color">
        <div class="container-fluid bg-light rounded-5 mx-3 p-3">
            <a class="navbar-brand py-2" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <div class="w-75 py-2 ms-lg-auto me-lg-auto ms-sm-auto me-sm-auto">
                    <form class="d-flex" role="search">
                        <input class="form-control form-control-lg form-control-sm rounded-start-5" type="search" :placeholder="__('Search')" aria-label="Search">
                        <button class="btn btn-primary rounded-end-5" type="submit"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                    </form>
                </div>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 py-2">

                    <li class="nav-item dropdown">
                        <button class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-circle-user"></i> {{ __("Account") }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><button class="dropdown-item" href="#">Action</button></li>
                            <li><button class="dropdown-item" href="#">Another action</button></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><button class="dropdown-item" href="#">Something else here</button></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" href="#"> <i class="fa-solid fa-heart"></i> {{ __("Favorites") }}</button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" href="#"> <i class="fa-solid fa-basket-shopping"></i> {{ __("Basket") }}</button>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
</template>
