# TYPO3 extension in2frontendauthentication

## Introduction

TYPO3 extension to simulate fe-login for a group if IP-address (IPv4 and IPv6) fits.
Set ip addresses in fe_groups.

## Introduction

![Set an IP address in a fe_groups record](Documentation/Images/backend_fegroup.png)

![Define that a content should only be shown if a group has authenticated](Documentation/Images/backend_pagecontent.png)

![Show content if authenticated in frontend](Documentation/Images/frontend_pagecontent.png)

**Note:** This allows you to show/hide contentelements, pages and other records to a specific usergroup.
But "showAtAnyLogin" or "hideAtAnyLogin" is not supported.

## Requirements and installation

```
composer require in2code/in2frontendauthentication
```

This extension requires an installation via composer because we use the mlocati/ip-lib.

## Static File Cache

The extension staticfilecache sets a cookie to identify, whether a user is logged in and the static file cache may not
be used. It hooks into the normal authentication process, when the user is initialized. With 
EXT:in2frontendauthentication there are no specific frontend users, so it must be set here too.

This feature can be enabled in the extension settings in the extension manager. 

## Supported TYPO3-Versions

* TYPO3 9.5
* TYPO3 8.7
* TYPO3 7.6

## Supported Extension

* fal_securedownload in version 2.0 or newer

## Changelog

| Version    | Date       | State      | Description                                                                  |
| ---------- | ---------- | ---------- | ---------------------------------------------------------------------------- |
| 4.0.0      | 2020-01-22 | Feature    | Add support for IP V6. This is the first Release with the composer requirement "mlocati/ip-lib" |
| 3.0.0      | 2020-01-20 | Feature    | Support TYPO3 V9. This is the last release without composer requirement      |
| 2.0.3      | 2019-10-07 | Bugfix     | Fix another regression for the latest feature                                |
| 2.0.2      | 2019-10-07 | Bugfix     | Change namespace to CookieService class                                      |
| 2.0.1      | 2019-10-07 | Bugfix     | Fix exception when instantiating CookieService class of staticfilecache      |
| 2.0.0      | 2019-09-30 | Feature    | Respect staticfilecache cookies                                              |
| 1.1.1      | 2017-07-18 | Bugfix     | Signal update from fal_securedownload                                        |
| 1.1.0      | 2017-07-10 | Feature    | Support EXT:fal_securedownload >= version 2.0.0                              |
| 1.0.2      | 2016-08-03 | Bugfix     | Allow multiple usergroups                                                    |
| 1.0.1      | 2016-06-23 | Bugfix     | Small fix in german locallang                                                |
| 1.0.0      | 2016-06-10 | Task       | Initial release                                                              |
