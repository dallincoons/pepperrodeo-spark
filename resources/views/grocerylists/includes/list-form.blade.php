<div class="title-section">
    <label for="title" class="form-heading">Title*</label>
    <input type="text" placeholder="September Grocery List" v-model="title" id="title" name="title">

</div>

<a v-on:click="setShowRecipes(true)" class="create-list-option"><i class="fa fa-plus-circle"></i> Add a recipe</a>
<div class="recipes-added">
    <p v-for="(recipe, index) in addedRecipes" class="recipe-added">
        <a v-on:click="removeRecipe(recipe.id, index)">X</a> | @{{recipe.title}}
    </p>
    <input type="hidden" name="recipeIds" :value="recipeIds">
</div>
<a v-on:click="setAddAnItem(true)" class="create-list-option"><i class="fa fa-plus-circle"></i> Add an item</a>
<div class="item-section" v-if="addAnItem">
    <div class="items-inputs">
        <div class="ingredient-input">
            <label for="quantity" class="sub-heading">Qty</label>
            <input type="text" id="quantity" v-model="newItemQty" name="'recipeFields[' + index + '][quantity]'" class="ingredient-info" placeholder="1" />
        </div>

        <div class="ingredient-input">
            <label for="type" class="sub-heading">Type</label>
            <input type="text" id="type" class="ingredient-info" placeholder="bottle">
        </div>

        <div class="ingredient-input">
            <label for="item" class="sub-heading">Item</label>
            <input type="text" id="item" v-model="newItemName" name="'recipeFields[' + index + '][name]'" class="ingredient-info" placeholder="shampoo"/>
        </div>

        <div class="ingredient-input">
            <label for="category" class="sub-heading dept-label">Department</label>
            <select name="category" v-model="newItemCategoryId">
                @foreach($itemCategories as $category)
                    <option value="{{ $category->id }}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="add-wrapper ingredient-input">
            <button type="button" v-on:click="addItem(recipeFields)" class="add-button"><i class="fa fa-plus-circle"></i></button>
        </div>
    </div>
</div>

<div class="category-wrapper">
    <ul class="category" v-for="(items, index) in itemsGrouped">
        <li class="category-title"><h3>@{{ index }}</h3></li>
        <ul class="recipes list-items">
            <li v-for="item in items" class="list-item">
                <span class="list-item-added">@{{ item.quantity }}</span>
                <span class="list-item-added">@{{ item.type }}</span>
                <span class="list-item-added">@{{ item.name }} </span>
                <span v-on:click="removeItem(item.id)" class="remove-item list-item-added">X</span>

                <input type="hidden" :name="'items[' + item.id + '][quantity]'" :value="item.quantity">
                <input type="hidden" :name="'items[' + item.id + '][name]'" :value="item.name">
                <input type="hidden" :name="'items[' + item.id + '][item_category_id]'" :value="item.item_category_id">
                <input type="hidden" :name="'items[' + item.id + '][id]'" :value="item.id">
            </li>
        </ul>
    </ul>
</div>

<div class="centering-buttons">
    <button type="submit" class="save-button pr-button">Save List</button>
</div>

@if (count($errors) > 0)
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
