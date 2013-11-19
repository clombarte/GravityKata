Gravity Kata
=============

Create a system that shows how stacked ice blocks behave with gravity.

Here are some examples of how the ice blocks behave in this system:



Adding blocks:

<pre>

    Before          After

--->|X|

                   |X|
-----------------------------

</pre>

Shifting blocks from left:

<pre>

    Before          After

    |X|
--->|X|            |X||X|
--------------------------

    Before          After

    |X||X||X|         |X||X|
--->|X||X||X|      |X||X||X||X|
-----------------------------


    Before           After

    |X||X||X|         |X||X|
--->|X||X||X|      |X||X||X|
    |X||X||X|      |X||X||X||X|
-------------------------------

    Before           After

       |X||X|         |X||X|
--->|X||X||X|         |X||X||X|
    |X||X||X||X|   |X||X||X||X|
-------------------------------

</pre>


Rules
------

1. The grid must be of 3 rows and 5 columns
2. Block invalid input simulation data
3. Provide coordinates to push a block (only from the left)
4. If the coordinates are invalid for whatever reason, blocks that are falling will still continue to simulate
