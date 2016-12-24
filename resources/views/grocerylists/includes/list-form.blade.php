<div v-show="editing">
    <div class="title-section">
        <label for="title" class="form-heading">Title*</label>
        <input type="text" placeholder="September Grocery List" v-model="title" id="title" name="title" required data-parsley-errors-messages-disabled>

    </div>

    <a v-on:click="setShowRecipes(true)" class="create-list-option"><i class="fa fa-plus-circle"></i> Add a recipe</a>

    <a v-on:click="setAddAnItem(true)" class="create-list-option"><i class="fa fa-plus-circle"></i> Add an item</a>
</div>
<div class="item-section" v-if="addAnItem">
    <div class="items-inputs">
        <div class="ingredient-input">
            <label for="quantity" class="sub-heading">Qty</label>
            <input type="text" id="quantity" v-model="newItemQty" name="'recipeFields[' + index + '][quantity]'" class="ingredient-info" placeholder="1" @keyup.enter="addItem(recipeFields)"/>
        </div>

        <div class="ingredient-input">
            <label for="type" class="sub-heading">Type</label>
            <input type="text" id="type" v-model="newItemType" name="'recipeFields[' + index + '][type]'" class="ingredient-info" placeholder="bottle" @keyup.enter="addItem(recipeFields)">
        </div>

        <div class="ingredient-input">
            <label for="item" class="sub-heading">Item</label>
            <input type="text" id="item" v-model="newItemName" name="'recipeFields[' + index + '][name]'" class="ingredient-info" placeholder="shampoo" @keyup.enter="addItem(recipeFields)"/>
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
            <button type="button" v-on:click="addAnItem = false" class="add-button"><i class="fa fa-times-circle-o"></i></button>
        </div>
    </div>
</div>

<div class="category-wrapper">
    <ul class="category" v-for="(items, groupName) in itemsGrouped">
        <li class="category-title"><h3>@{{ groupName }}</h3></li>
        <ul class="recipes list-items">
            <li v-for="item in items" class="list-item">
                <div class="list-item-wrapper">
                    <span class="list-item-added">@{{ item.quantity }}</span>
                    <span class="list-item-added">@{{ item.type }}</span>
                    <span class="list-item-added">@{{ item.name }} </span>
                </div>
                <span v-on:click="removeItem(item.id)" class="remove-item list-item-added"><i class="fa fa-times-circle-o"></i></span>

                <input type="hidden" :name="'items[' + item.id + '][quantity]'" :value="item.quantity">
                <input type="hidden" :name="'items[' + item.id + '][name]'" :value="item.name">
                <input type="hidden" :name="'items[' + item.id + '][type]'" :value="item.type">
                <input type="hidden" :name="'items[' + item.id + '][item_category_id]'" :value="item.item_category_id">
                <input type="hidden" :name="'items[' + item.id + '][id]'" :value="item.id">
            </li>
        </ul>
    </ul>
</div>

<div class="centering-buttons" v-show="editing">
    <button type="button" v-on:click="submitListForm()" class="save-button  " :disabled="!items.length">Save List</button>
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
