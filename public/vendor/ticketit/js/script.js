$(document).ready(function() {
    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#alert").alert('close');
    });
    
    $('input[list]').on('input', function(e) {
        var $input = $(e.target);
        var $tagsBlock = $input.closest('.tags-block');
        var $options = $tagsBlock.find('#' + $input.attr('list') + ' option');
        var $hiddenInput = $tagsBlock.find('input[name="category"]');
        var $hiddenInputId = $tagsBlock.find('input[name="category-id"]');
        var $hiddenInputColor = $tagsBlock.find('input[name="category-color"]');
        var label = $input.val();

        $hiddenInput.val(label);

        for (var i = 0; i < $options.length; i++) {
            $hiddenInput.val('');
            $hiddenInputId.val('');
            $hiddenInputColor.val('');
            var $option = $options.eq(i);

            if ($option.text() === label) {
                $hiddenInput.val($option.val());
                $hiddenInputId.val($option.attr('data-value'));
                $hiddenInputColor.val($option.attr('data-color'));
                break;
            }
        }
    });


    $('.suggest-holder').on('keypress', function(e) {
        if (e.keyCode == 13) {
            var $parentDiv = $(this).closest('.tags-block');
            $parentDiv.find('.save').click();
            return false;
        }
    });


    $(document).on('click', '.save', function() {
        var $parentDiv = $(this).closest('.tags-block');
        var $parentForm = $parentDiv.closest('form');
        var $category = $parentDiv.find('input[name="category"]').val();
        var $ajaxUrl = $parentForm.attr('action');
        var $method = $parentForm.find('input[name="_method"]').val();
        var $token = $parentForm.find('input[name="_token"]').val();
        var $categoryId = $parentDiv.find('input[name="category-id"]').val();
        var $categoryColor = $parentDiv.find('input[name="category-color"]').val();
        $catBlock = $parentForm.closest('tr').find('#cat-block');
        if ($.trim($category) !== '' && $categoryId !== undefined) {
            $.ajax({
                type: "PATCH",
                url: $ajaxUrl,
                data: {
                    'category-id': $categoryId,
                    '_token': $token,
                    '_method': $method,
                    '_action': 'save'
                },
                success: function(data) {
                    append(data);
                },
                error: function(result) {
                    alert('An error has occurred.');
                }
            });
        }
        $('.suggest-holder').val('');
        return false;
    });


    $(document).on('click', '.delete', function() {
        var $id = $(this).attr('id');
        var $sibDiv = $(this).closest('.tags-block');
        var $sibForm = $sibDiv.closest('td').find('form');
        var $ajaxUrl = $sibForm.attr('action');
        var $method = $sibForm.find('input[name="_method"]').val();
        var $token = $sibForm.find('input[name="_token"]').val();
        $catBlock = $sibForm.closest('tr').find('#cat-block');
        if ($id !== undefined) {
            $.ajax({
                type: "PATCH",
                url: $ajaxUrl,
                data: {
                    'category-id': $id,
                    '_token': $token,
                    '_method': $method,
                    '_action': 'delete'
                },
                success: function(data) {
                    append(data);
                },
                error: function(result) {
                    alert('An error has occurred.');
                }
            });
        }
        return false;
    });


    function append(data) {
        $catBlock.html('');
        for (var i = 0; i < data.categories.length; i++) {
            $cat = data.categories[i];
            $catBlock.append($('<span style="border-left: 5px solid ' + $cat.color + ';" class="tag"><span class="tag-name">' + $cat.name + '</span><a name="delete" id="' + $cat.id + '" class="delete"><span title="Delete" class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></span>'));
        }
    }
});