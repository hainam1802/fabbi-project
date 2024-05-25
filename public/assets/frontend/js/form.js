$(document).ready(function(){
    let dishCount = 1;
    let availableDishes = [];

    function showTab(n) {
        $('.tab-content').removeClass('active');
        $('#step' + n).addClass('active');
        $('.tab').removeClass('active');
        $('#tab' + n).addClass('active');
    }

    function validateStep1() {
        let valid = true;
        if ($('#meal').val() === '' || $('#quantity').val()  === '') {
            valid = false;
        }
        return valid;
    }

    function validateStep2() {
        return $('#restaurant').val() !== '';
    }

    function validateStep3() {
        let valid = true;
        $('.dish-group').each(function() {
            if ($(this).find('.dish').val() === '' || $(this).find('.quantity').val() === '') {
                valid = false;
            }
        });
        return valid;
    }

    $('#next1').click(function() {
        if (validateStep1()) {
            showTab(2);
        } else {
            alert('Please select Meal and Number of people.');
        }
    });

    $('#prev2').click(function() {
        showTab(1);
    });

    $('#next2').click(function() {
        if (validateStep2()) {
            showTab(3);
        } else {
            alert('Please Select a Restaurant.');
        }
    });

    $('#prev3').click(function() {
        showTab(2);
    });

    $('#next3').click(function() {
        if (validateStep3()) {
            let meal = $('#meal').val();
            let restaurant = $('#restaurant').val();
            let quantity_people = $('#quantity').val();
            let dishes = [];
            $('.dish-group').each(function() {
                let dish = $(this).find('.dish').val();
                let quantity = $(this).find('.quantity').val();
                if (dish && quantity) {
                    dishes.push({ dish: dish, quantity: quantity });
                }
            });

            $('#reviewMeal').text('Meal: ' + meal);
            $('#reviewQuantity').text('No of people: ' + quantity_people);

            $('#reviewRestaurant').text('Restaurant: ' + restaurant);
            let dishList = 'Dishes:';
            dishList += '<ul>';
            console.log(availableDishes)
            dishes.forEach(function(d) {
                // Retrieve dish name from availableDishes array using dish ID
                let dishName = Object.values(availableDishes).find(function(dish) {
                    return dish.id == d.dish;
                }).name;
                dishList += '<li>' + dishName + ' - ' + d.quantity + '</li>';
            });
            dishList += '</ul>';
            $('#reviewDishes').html(dishList);

            showTab(4);
        } else {
            alert('Please select at least one dish and enter the number of servings.');
        }
    });

    $('#prev4').click(function() {
        showTab(3);
    });

    $('#meal').change(function() {
        let meal = $(this).val();
        if (meal) {
            $.ajax({
                url: '/get-restaurants',
                type: 'GET',
                data: { meal: meal },
                success: function(data) {
                    $('#restaurant').empty().append('<option value="">--Select a Restaurant--</option>');
                    $.each(data, function(key, value) {
                        $('#restaurant').append('<option value="' + value + '">' + value +
                            '</option>');
                    });
                }
            });
        }
    });

    $('#restaurant').change(function() {
        let meal = $('#meal').val();
        let restaurant = $(this).val();
        if (meal && restaurant) {
            $.ajax({
                url: '/get-dishes',
                type: 'GET',
                data: { meal: meal, restaurant: restaurant },
                success: function(data) {
                    availableDishes = data;
                    updateDishOptions();
                }
            });
        }
    });

    $('#addDish').click(function() {
        if (!validateStep3()) {
            alert('Please select at least one dish and enter the number of servings.');
            return false;

        }
        let newDishGroup = `
                    <div class="dish-group mb-2">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="dish">Please Select a Dish:</label>
                                <select class="form-control dish" name="dishes[${dishCount}][dish]">
                                    <option value="">--Select a Dish--</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="quantity">Please enter no of servings:</label>
                                <input type="number" class="form-control quantity" name="dishes[${dishCount}][quantity]" min="1" value="1">
                            </div>
                            <div class="col-md-2 mt-4">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-danger removeDish">Delete</button>
                            </div>
                        </div>
                    </div>
                `;
        $('#dishContainer').append(newDishGroup);
        updateDishOptions();
        dishCount++;
    });

    $('#dishContainer').on('click', '.removeDish', function() {
        $(this).closest('.dish-group').remove();
    });

    $('#meal, #restaurant').change(function() {
        updateDishOptions();
    });

    function updateDishOptions() {
        let selectedDishes = $('.dish').map(function() {
            return $(this).val();
        }).get();

        $('.dish').each(function() {
            let currentDish = $(this).val();
            $(this).empty().append('<option value="">--Select a Dish--</option>');
            $.each(availableDishes, function(key, value) {
                if (!selectedDishes.includes(value.id.toString()) || value.id.toString() === currentDish) {
                    $(this).append('<option value="' + value.id + '">' + value.name + '</option>');
                }
            }.bind(this));
            $(this).val(currentDish);
        });
    }

    // Listen for changes in the dish dropdowns to toggle the "Add Dish" button
    $('#dishContainer').on('change', '.dish', function() {
        let dishSelect = $(this);
        let quantityInput = dishSelect.closest('.dish-group').find('.quantity');

        // Show add button only when both dish and quantity are selected/entered
        if (dishSelect.val() && quantityInput.val()) {
            dishSelect.closest('.dish-group').find('.addDishButton').show();
        } else {
            dishSelect.closest('.dish-group').find('.addDishButton').hide();
        }
    });

    // Click event for the add dish button
    $('#dishContainer').on('click', '.addDishButton', function() {
        let newDishGroup = `
                    <div class="dish-group mb-2">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="dish">Please Select a Dish:</label>
                                <select class="form-control dish" name="dishes[${dishCount}][dish]">
                                    <option value="">--Select a Dish--</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="quantity">Please enter no of servings:</label>
                                <input type="number" class="form-control quantity" name="dishes[${dishCount}][quantity]" min="1" value="1">
                            </div>
                            <div class="col-md-2">
                                <label>&nbsp;</label>
<!--                                <button type="button" class="btn btn-danger removeDish">Delete</button>-->
                            </div>
                        </div>
                    </div>
                `;
        $('#dishContainer').append(newDishGroup);
        dishCount++;
    });

});
