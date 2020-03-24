<?php
// Set the type of files allowed
$handle->allowed = 'image/*';
// Overwrite the file if it already exists.
$handle->file_overwrite = true;
// Set the max file size.
$handle->file_max_size = '2147483648';
// Resize the image
$handle->image_resize = true;
$handle->image_x = '960';
$handle->image_y = '540';
// New filename
$handle->file_new_name_body = 'codedodle';