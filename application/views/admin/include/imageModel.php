<div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
				<img src="" class="enlargeImageModalSource" style="width: 100%;">
			</div>
		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
//remove image
function removeImage(image_no='')
{
    $('.file'+image_no).empty();
    document.getElementById("file"+image_no).value = null;
}

$(function() {
    $('img').on('click', function() {
		$('.enlargeImageModalSource').attr('src', $(this).attr('src'));
		$('#enlargeImageModal').modal('show');
	});

	// Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview, image_no='') {
    	if (input.files) 
        {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) 
            {
                var reader = new FileReader();

                reader.onload = function(event) {
                	$($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                    $('<button type="button" class="btn btn-danger" onclick="removeImage('+image_no+');">Remove</button>').appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }
	};

    $('#file1').on('change', function() {
    	$('.file1').empty();
        imagesPreview(this, 'div.file1', 1);
    });

    $('#file2').on('change', function() {
    	$('.file2').empty();
        imagesPreview(this, 'div.file2', 2);
    });

    $('#file3').on('change', function() {
    	$('.file3').empty();
        imagesPreview(this, 'div.file3', 3);
    });

    $('#file4').on('change', function() {
    	$('.file4').empty();
        imagesPreview(this, 'div.file4', 4);
    });

    $('#file5').on('change', function() {
    	$('.file5').empty();
        imagesPreview(this, 'div.file5', 5);
    });

    $('#file6').on('change', function() {
    	$('.file6').empty();
        imagesPreview(this, 'div.file6', 6);
    });

    $('#file7').on('change', function() {
        $('.file7').empty();
        imagesPreview(this, 'div.file7', 7);
    });

    $('#file8').on('change', function() {
        $('.file8').empty();
        imagesPreview(this, 'div.file8', 8);
    });

    $('#file').on('change', function() {
        $('.file').empty();
        imagesPreview(this, 'div.file');
    });
});
</script>

<style type="text/css">
img {
    cursor: zoom-in;
}

.file img, .file1 img, .file2 img, .file3 img, .file4 img, .file5 img, .file6 img, .file7 img, .file8 img{
	height: 50px;
	cursor: default;
}

.file img{
    margin: 2px;   
}
</style>
