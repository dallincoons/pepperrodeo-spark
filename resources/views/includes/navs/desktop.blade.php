<nav class="l-nav">
    <ul>
        <li class="l-brand"><a href="/"><h1>Pepper Rodeo</h1></a></li>
        <li class="l-brand l-subtitle">Your recipes & grocery lists in one place.</li>

        <li  class="l-nav-li"><a href="/recipe" class="{{ set_active_strict('recipe') }}"><i class="fa fa-cutlery"></i> My Recipes</a>
            <div class="l-dropdown-content">
                <a href="/recipe/create" class="{{ set_active_strict('recipe/create') }}"><i class="fa fa-plus"></i> Add a Recipe</a>
                <a><i class="fa fa-cart-plus"></i> Add Recipes to List</a>
                <a href="/recipe/delete" class="{{ set_active_strict('recipe/delete') }}"><i class="fa fa-trash"></i> Delete Recipes</a>
            </div>

        </li>

        <li class="l-nav-li"><a href="/grocerylist" class="{{ set_active_strict('grocerylist') }}"><i class="fa fa-shopping-cart"></i> My Lists</a>
            <div class="l-dropdown-content">
                <a href="/grocerylist/create" class="{{ set_active_strict('grocerylist/create') }}"><i class="fa fa-plus"></i> Create New List</a>
                <a><i class="fa fa-trash"></i> Delete Lists</a>
            </div>
        </li>
        <li class="l-nav-li"><a><i class="fa fa-user"></i> My Settings</a></li>
    </ul>
</nav>
