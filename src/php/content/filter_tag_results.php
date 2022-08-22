<div class="container d-flex align-items-center mb-3">
    <p class='text-secondary mt-1 mb-1 me-auto'><span id='number_of_results'><?php  echo $repo->getTagsCount(); ?></span> result(s) avaible.</p>
    <div class="d-flex align-items-center sort">
        <p class="me-2 mb-0">Sort by </p>
        <div class='dropdown me-2'>
            <button class='btn btn-outline-alert dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                Sugested
            </button>
            <ul class='dropdown-menu'>
                <li><a class='dropdown-item' href='#'>Action</a></li>
                <li><a class='dropdown-item' href='#'>Another action</a></li>
                <li><a class='dropdown-item' href='#'>Something else here</a></li>
            </ul>
        </div>
        <form class="d-flex " role="search">
            <input class="form-control me-2" type="search" placeholder="Recherche par mot clé.." aria-label="Search">
            <button class="btn " type="submit">Search</button>
        </form>
    </div>
</div>

