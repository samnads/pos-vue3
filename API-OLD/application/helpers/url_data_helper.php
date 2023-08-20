<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function raw_input_to_post()
{
    $ci = &get_instance();
    $post = $ci->input->raw_input_stream;
    $post = json_decode($post);
    $post = json_decode(json_encode($post), true);
    return $post;
}