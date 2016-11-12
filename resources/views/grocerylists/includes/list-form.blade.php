<label for="title" class="form-heading">Title*</label>

<input type="text" placeholder="September Grocery List" v-model="title" id="title" class="form-heading" name="title">
<a v-on:click="setShowRecipes(true)"><i class="fa fa-plus-circle"></i> Add a recipe</a>

<div class="recipes-added">
    <p v-for="(recipe, index) in addedRecipes">
        <a v-on:click="removeRecipe(recipe.id, index)">X</a> | @{{recipe.title}}
    </p>
    <input type="hidden" name="recipeIds" :value="recipeIds">
</div>
<a v-on:click="setAddAnItem(true)"><i class="fa fa-plus-circle"></i> Add an item</a>
<div class="item-section" v-if="addAnItem">
    <div class="items-inputs">
        <div class="qty">
            <label for="quantity" class="sub-heading">Qty</label>
            <input type="text" id="quantity" v-model="newItemQty" name="'recipeFields[' + index + '][quantity]'" class="qty-input" placeholder="1" />
        </div>

        <div class="ingredient">
            <label for="item" class="sub-heading">Item</label>
            <input type="text" id="item" v-model="newItemName" name="'recipeFields[' + index + '][name]'" class="ingredient-input" placeholder="shampoo"/>
        </div>

        <div class="item-categories">
            <label for="category" class="sub-heading dept-label">Department</label>
            <select name="category" v-model="newItemCategoryId">
                @foreach($itemCategories as $category)
                    <option value="{{ $category->id }}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="add-wrapper">
            <button type="button" v-on:click="addItem(recipeFields)" class="add-button">Add</button>
        </div>
    </div>
</div>

<div class="category-wrapper">
    <ul class="category">
        <li class="category-title"><h3>General</h3></li>
        <ul class="recipes list-items">
            <li v-for="(item, index) in items">
                <span>@{{ item.quantity }}</span>
                <span>@{{ item.type }}</span>
                <span>@{{ item.name }} </span>
                <span v-on:click="removeItem(index)" class="remove-item">X</span>

                <input type="hidden" :name="'items[' + index + '][quantity]'" :value="item.quantity">
                <input type="hidden" :name="'items[' + index + '][name]'" :value="item.name">
                <input type="hidden" :name="'items[' + index + '][item_category_id]'" :value="item.item_category_id">
                <input type="hidden" :name="'items[' + index + '][id]'" :value="item.id">
            </li>
        </ul>
    </ul>
</div>

<div class="save-button">
    <button type="submit" class="pr-button">Save List</button>
</div>
