## Introduction

TYPO3 extension to simulate fe-login for a group if IP-address fits.
Set ip addresses in fe_groups.

<img src="https://box.everhelper.me/attachment/504010/a2afed54-7cb5-4e1a-bd0c-f21398236304/262407-2k6yGwBCEmgeKSJU/screen.png" alt="example usergroup configuration" />

<img src="https://box.everhelper.me/attachment/504018/a2afed54-7cb5-4e1a-bd0c-f21398236304/262407-6xMmMIsdvaIv8tUz/screen.png" alt="example contentelement that's normally only visible for users of group 'Test'" />

**Note:** This allows you to show/hide contentelements, pages and other records to a specific usergroup.
But "showAtAnyLogin" or "hideAtAnyLogin" is not supported at the moment.

## Static File Cache

The extension staticfilecache sets a cookie to identify, whether a user is logged in and the static file cache may not
be used. It hooks into the normal authentication process, when the user is initialized. With 
EXT:in2frontendauthentication there are no specific frontend users, so it must be set here too.

This feature can be enabled in the extension settings in the extension manager. 

## Supported TYPO3-Versions

* TYPO3 8.7
* TYPO3 7.6

## Supported Extension

* fal_securedownload in version 2.0 or newer

## Changelog

| Version    | Date       | State      | Description                                                                  |
| ---------- | ---------- | ---------- | ---------------------------------------------------------------------------- |
| 2.0.1      | 2019-10-07 | Bugfix     | Fix exception when instantiating CookieService class of staticfilecache      |
| 2.0.0      | 2019-09-30 | Feature    | Respect staticfilecache cookies                                              |
| 1.1.1      | 2017-07-18 | Bugfix     | Signal update from fal_securedownload                                        |
| 1.1.0      | 2017-07-10 | Feature    | Support EXT:fal_securedownload >= version 2.0.0                              |
| 1.0.2      | 2016-08-03 | Bugfix     | Allow multiple usergroups                                                    |
| 1.0.1      | 2016-06-23 | Bugfix     | Small fix in german locallang                                                |
| 1.0.0      | 2016-06-10 | Task       | Initial release                                                              |
