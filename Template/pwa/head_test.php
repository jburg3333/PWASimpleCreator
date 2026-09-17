<?php
file_put_contents(__DIR__ . '/test.txt', var_export(array_keys(get_object_vars($this)), true));
file_put_contents(__DIR__ . '/test2.txt', get_class($this));
