<?php

test('the application redirects the root path to login', function () {
    $response = $this->get('/');

    $response->assertRedirect('/login');
});
