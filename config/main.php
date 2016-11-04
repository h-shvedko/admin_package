<?php

return array(
    'modules' => array(
        'admin' => array(
            'modules' => array(
                'packagesbase' => array(
                    'import' => array(
                        'application.modules.admin.modules.catalog.*',
                        'application.modules.admin.modules.coursesprice.models.Prices',
                        'application.modules.office.modules.courses.models.*',
                    )
                ),
            ),
        ),
    ),
);

