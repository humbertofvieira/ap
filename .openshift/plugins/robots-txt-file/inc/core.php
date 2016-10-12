<?php
function cd_rdte_filter_robots($rv, $public)
{
    $content = get_option('cd_rdte_content');
    if ($content) {
        $rv = esc_attr(strip_tags($content));
    }

    return $rv;
}
function cd_rdte_deactivation()
{
    delete_option('cd_rdte_content');
}

function cd_rdte_activation()
{
    add_option('cd_rdte_content', false);
}
