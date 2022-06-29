<?php

/** Lock down User listing from REST API */
/**
 * Wrap an existing default callback passed in parameter and create
 * a new permission callback introducing preliminary checks and
 * falling-back on the default callback in case of success.
 */
function permission_callback_hardener($existing_callback)
{
    return function ($request) use ($existing_callback) {
        if (! current_user_can('list_users')) {
            return new WP_Error(
                'rest_user_cannot_view',
                __('Sorry, you are not allowed to access users.'),
                [ 'status' => rest_authorization_required_code() ]
            );
        }

        return $existing_callback($request);
    };
}

function api_users_endpoint_force_auth($endpoints)
{
    $users_get_route = &$endpoints['/wp/v2/users'][0];
    if ($users_get_route) {
        $users_get_route['permission_callback'] = permission_callback_hardener($users_get_route['permission_callback']);
    }

    $user_get_route = &$endpoints['/wp/v2/users/(?P<id>[\d]+)'][0];
    if ($user_get_route) {
        $user_get_route['permission_callback'] = permission_callback_hardener($user_get_route['permission_callback']);
    }

    return $endpoints;
}

add_filter('rest_endpoints', 'api_users_endpoint_force_auth');
