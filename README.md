array-abstraction
================

Abstraction for built-in arrays and objects implementing ArrayAccess/Iterator/Countable interfaces.

This library is meant to abstract away the differences between PHP's built-in arrays and the different interfaces objects 
can implement to hook into the array syntax. PHP has a lot of built-in functions for arrays, but they only work on 
built-in arrays and not on objects implementing the array-like interfaces, so this library implements variants for all of 
PHP's array-related functions that work on either. The idea is that all built-in functions listed at 
http://php.net/manual/en/ref.array.php have a generic counterpart in the Utils class. 

Gotcha's
--------

- Functionality is implemented to support as much as possible. This means that you can, for example, use an offsetExists 
on an object implementing only the Traversable interface, and not ArrayAccess. It works, but is not very efficient, and 
probably not what you want.

Proxy objects
-------------

The concept of proxy objects allow you to wire your own array-like objects with optimized implementations for the 
different array-like functions if you need to. By creating a proxy object, you can use PHP's optimized built-in 
functions where possible, depending on the type of backend storage you're using. 

Because the ProxyInterface contains a lot of functions, consider extending from BaseProxy when creating your own Proxy 
classes. This way you don't have to implement functionality that you're not going to use anyway. If the backend storage 
of your new proxy class is an array, consider extending from the ArrayProxy class, it has implementations that forward
all operations to PHP's built-in array functions.
