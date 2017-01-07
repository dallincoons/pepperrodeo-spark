<div v-show="editing">
    <div class="title-section">
        <label for="title" class="form-heading">Title*</label>
        <input type="text" placeholder="September Grocery List" v-model="title" id="title" name="title" required data-parsley-errors-messages-disabled>

    </div>

    <a v-on:click="setShowRecipes(true)" class="create-list-option"><i class="fa fa-plus-circle"></i> Add a recipe</a>

    <a v-on:click="setAddAnItem(true)" class="create-list-option"><i class="fa fa-plus-circle"></i> Add an item</a>
</div>


<div class="list-cat-wrapper category-wrapper">
    <ul class="category" v-for="(items, groupName) in itemsGrouped">
        <li class="category-title"><h3>@{{ groupName }}</h3> <span v-on:click="deleteGroup(items)"><i class="fa fa-times-circle-o"></i></span></li>
        <ul class="recipes list-items">
            <li v-for="item in items" class="list-item">
                <div class="list-item-wrapper">
                    <span class="list-item-added">@{{ item.quantity }}</span>
                    <span class="list-item-added">@{{ item.type }}</span>
                    <span class="list-item-added">@{{ item.name }} </span>
                </div>
                <div class="options-dropdown-wrapper">
                    <a class="dropdown-indicator" v-on:click="toggleListOptions(item)" ><i class="fa fa-ellipsis-h"></i></a>
                    <ul class="options-dropdown" v-show="item.toggleOptions">
                        <li><i class="fa fa-pencil"></i><a> Edit Item</a></li>
                        <li v-on:click="removeItemFromList(item)"><i class="fa fa-trash-o"></i><a> Delete Item</a></li>
                    </ul>
                </div>


                <input type="hidden" :name="'items[' + item.id + '][quantity]'" :value="item.quantity">
                <input type="hidden" :name="'items[' + item.id + '][name]'" :value="item.name">
                <input type="hidden" :name="'items[' + item.id + '][type]'" :value="item.type">
                <input type="hidden" :name="'items[' + item.id + '][department_id]'" :value="item.department_id">
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
