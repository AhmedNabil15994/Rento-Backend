<?php

return [
    // "logut_url" => env("BBB_LOGOUT_URL",url("/")),
    // "end_callback" => env("BBB_END_CALLBACK",url("/")),
    // "end_record_callback" => env("BBB_END_RECORD_CALLBACK",url("/")),
    "teacher_code" =>"teacher",
    "student_code" =>"student",
    /**
     * Default BigBlueButton Server Configurations
     * By default load this configuration not a multiple server configuration.
     */
    'BBB_SECURITY_SALT'   => env('BBB_SECURITY_SALT', 'dFDRkxNjK2rmCL8zQIaMmVphjzj0D4SRhafRFUCiDM'),
    'BBB_SERVER_BASE_URL' => env('BBB_SERVER_BASE_URL', 'https://bbb.ilearnkw.com/bigbluebutton/'),

    /**
     * For Multiple BigBlueButton Server Configurations
     * For Each server you must be specify salt and url with define server name
     * Note : if you want to used multiple server configuration you must specify servername.
     */
    'servers' => [
        'server1' => [
            'BBB_SECURITY_SALT'    => '',
            'BBB_SERVER_BASE_URL' => '',
        ],
        'server2' => [
            'BBB_SECURITY_SALT'    => '',
            'BBB_SERVER_BASE_URL' => '',
        ],
    ],

    'create'              => [
        /**
         * if user does not pass attendee or moderator password then
         * generate random password (length should be there).
         *
         * var @numeric
         */
        'passwordLength'                     => 8,

        /**
         * A welcome message that gets displayed on the chat window when the participant joins
         * if null then default server welcome message will be show..
         * var @mixed.
         **/
        'welcomeMessage'                     => null,

        /**
         * The dial access number that participants can call in using regular phone.
         *
         * var @string
         */
        'dialNumber'                         => null,

        /**
         *    Set the maximum number of users allowed to joined the conference at the same time.
         *    Note :  zero means unlimited participants
         *    var @numeric.
         */
        'maxParticipants'                    => 0,

        /**
         * The URL that the BigBlueButton client will go to after users click the OK button.
         *
         * var @string
         */
        'logoutUrl'                          => null,

        /**
         * Setting ‘record=true’ instructs the BigBlueButton server to record the media and
         * events in the session for later playback. The default is false.
         *
         * In order for a playback file to be generated, a moderator must click the Start/Stop Recording
         * button at least once during the session; otherwise, in the absence of any recording marks,
         * the record and playback scripts will not generate a playback file.
         * See also the autoStartRecording and allowStartStopRecording parameters
         * var @bool
         */
        'record'                             => false,

        /**
         * The maximum length (in minutes) for the meeting.
         * If duration contains a non-zero value,
         * then when the length of the meeting exceeds the duration value the server will immediately end the meeting
         * Note :  zero means unlimited participants.
         *
         * var @numeric
         */
        'duration'                           => 0,

        /**
         *    Must be set to true to create a breakout room. default set false.
         *
         * var @bool
         */
        'isBreakout'                         => false,

        /**
         * Display a message to all moderators in the public chat.
         * The value is interpreted in the same way as the welcome parameter.
         *
         * var @string
         */
        'moderatorOnlyMessage'               => null,

        /**
         * Whether to automatically start recording when first user joins (default false).
         * When this parameter is true, the recording UI in BigBlueButton will be initially active.
         * Moderators in the session can still pause and restart recording using the UI control.
         *
         * NOTE: Don’t pass autoStartRecording=false and allowStartStopRecording=false
         * the moderator won’t be able to start recording!
         *
         * var @bool
         */
        'autoStartRecording'                 => false,

        /**
         * Allow the user to start/stop recording. (default true)
         * If you set both allowStartStopRecording=false and autoStartRecording=true,
         * then the entire length of the session will be recorded,
         * and the moderators in the session will not be able to pause/resume the recording.
         *
         * var @bool
         */
        'allowStartStopRecording'            => true,

        /**
         * Setting webcamsOnlyForModerator=true will cause all webcams
         * shared by viewers during this meeting to only appear for moderators (added 1.1).
         *
         * var @bool
         */
        'webcamsOnlyForModerator'            => false,

        /**
         * Setting logo=http://www.example.com/my-custom-logo.png will replace
         * the default logo in the Flash client. (added 2.0).
         *
         * var @string
         */
        'logo'                               => null,

        /**
         * Will set the banner text in the client. (added 2.0).
         *
         * var @string
         */
        // 'bannerText'                         => null,

        /**
         * Will set the banner background color in the client.
         * The required format is color hex #FFFFFF. (added 2.0).
         *
         * var @string
         */
        //'bannerColor'                        => null,

        /**
         * Setting copyright=My custom copyright will replace
         * the default copyright on the footer of the Flash client. (added 2.0).
         *
         * var @string
         */
        'copyright'                          => "safwat",

        /**
         * Setting muteOnStart=true will mute all users when the meeting starts. (added 2.0).
         *
         * var @bool
         */
        'muteOnStart'                        => false,

        /**
         * Default allowModsToUnmuteUsers=false.
         * Setting to allowModsToUnmuteUsers=true will allow moderators to unmute other users in the meeting. (added 2.2).
         *
         * var @bool
         */
        //'allowModsToUnmuteUsers'             => false,

        /**
         *  Default lockSettingsDisableCam=false.
         * Setting lockSettingsDisableCam=true will prevent users from sharing their camera in the meeting. (added 2.2).
         *
         * var @bool
         */
        'lockSettingsDisableCam'             => false,

        /**
         * Default lockSettingsDisableMic=false.
         * Setting to lockSettingsDisableMic=true will only allow user to join listen only. (added 2.2).
         *
         * var @bool
         */
        'lockSettingsDisableMic'             => false,

        /**
         * Default lockSettingsDisablePrivateChat=false.
         * Setting to lockSettingsDisablePrivateChat=true will disable private chats in the meeting. (added 2.2).
         *
         * var @bool
         */
        'lockSettingsDisablePrivateChat'     => false,

        /**
         * Default lockSettingsDisablePublicChat=false.
         * Setting to lockSettingsDisablePublicChat=true will disable public chat in the meeting. (added 2.2).
         *
         * var @bool
         */
        'lockSettingsDisablePublicChat'      => false,

        /**
         * Default lockSettingsDisableNote=false.
         * Setting to lockSettingsDisableNote=true will disable notes in the meeting. (added 2.2).
         *
         * var @bool
         **/
        'lockSettingsDisableNote'            => false,

        /**
         * Default lockSettingsLockedLayout=false.
         * Setting to lockSettingsLockedLayout=true will lock the layout in the meeting. (added 2.2).
         *
         * var @bool
         */
        'lockSettingsLockedLayout'           => false,

        /**
         * Default lockSettingsLockOnJoin=true.
         * Setting to lockSettingsLockOnJoin=false will not apply lock setting to users when they join. (added 2.2).
         *
         * var @bool
         */
        'lockSettingsLockOnJoin'             => false,

        /**
         * Default lockSettingsLockOnJoinConfigurable=false.
         * Setting to lockSettingsLockOnJoinConfigurable=true will allow applying of lockSettingsLockOnJoin param. (added 2.2).
         *
         * var @bool
         */
        'lockSettingsLockOnJoinConfigurable' => false,

        /**
         * Default guestPolicy=ALWAYS_ACCEPT.
         * Will set the guest policy for the meeting.
         * The guest policy determines whether or not users
         * who send a join request with guest=true will be allowed to join the meeting.
         * Possible values are ALWAYS_ACCEPT, ALWAYS_DENY, and ASK_MODERATOR.
         *
         * var @string
         */
        'guestPolicy'                        => 'ALWAYS_ACCEPT',
    ],
    'join'                => [
        /**
         * var @bool.
         */
        'redirect'     => true,

        /**
         *    Set to “true” to force the HTML5 client to load for the user.
         *
         * var @bool
         */
        'joinViaHtml5' => true,
    ],
    'getRecordings'       => [
        /**
         * if the recording is [processing|processed|published|unpublished|deleted].
         * The parameter state can be used to filter results. It can be a set of states separate by commas.
         * If it is not specified only the states [published|unpublished] are considered
         * (same as in previous versions). If it is specified as “any”,
         * recordings in all states are included.
         *
         *  var @string
         */
        'state' => 'any', //'published,unpublished'
    ],
];
