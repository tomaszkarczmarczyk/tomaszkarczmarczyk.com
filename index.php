<?php

defined('ABSPATH') or exit();
status_header(404);
nocache_headers();
get_template_part(404);
exit();
