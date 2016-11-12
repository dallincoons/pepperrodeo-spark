<nav class="l-nav">
    <ul>
        <li class="{{ set_active('/') }} l-brand"><a href="/"><h1>Pepper Rodeo</h1></a></li>
        <li class="l-brand l-subtitle">Your recipes & grocery lists in one place.</li>

        <li class="{{ set_active('recipe') }} l-nav-li"><a href="/recipe"><i class="fa fa-cutlery"></i> My Recipes</a>
            <div class="l-dropdown-content">
                <a><i class="fa fa-plus"></i> Create New Recipe</a>
                <a><i class="fa fa-cart-plus"></i> Add Recipes to List</a>
                <a><i class="fa fa-trash"></i> Delete Recipes</a>
            </div>

        </li>

        <li class="{{ set_active('grocerylist') }} l-nav-li"><a href="/grocerylist"><i class="fa fa-shopping-cart"></i> My Lists</a>
            <div class="l-dropdown-content">
                <a><i class="fa fa-plus"></i> Create New List</a>
                <a><i class="fa fa-trash"></i> Delete Lists</a>
            </div>
        </li>
        <li class="l-nav-li"><a><i class="fa fa-user"></i> My Settings</a></li>
    </ul>
</nav>



{{--Mobile "footer" navigation--}}

<nav class="l-nav-mobile">
    <ul>
        <li class="{{ set_active('recipe') }}"><a href="/recipe"><i class="fa fa-cutlery"></i></a></li>
        <li class="{{ set_active('grocerylist') }}"><a href="/grocerylist"><i class="fa fa-shopping-cart"></i></a></li>
        <li class="{{ set_active('/') }}"><a href="/"><i class="fa fa-home"></i></a></li>
        <li><a><i class="fa fa-user"></i></a></li>
    </ul>
</nav>



