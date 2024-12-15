<?php

use Core\Container;

test('example', function () {
    // Arrange
    $container = new Container();
    $container->bind('foo', fn() => 'bar');
    // Act
    $result = $container->resolve('foo');
    // Assert/expect
    expect($result)->toEqual('bar');
});
