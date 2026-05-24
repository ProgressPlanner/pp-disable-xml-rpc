=== Disable XML-RPC by Progress Planner ===
Contributors: progressplanner
Donate link: https://progressplanner.com/
Tags: security, xml-rpc, hardening, disable xml-rpc
Requires at least: 6.7
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.6.1
License: MIT
License URI: https://mit-license.org

Disable WordPress XML-RPC completely with a lightweight, no-settings plugin.

== Description ==

Disable XML-RPC by Progress Planner is a focused utility plugin for WordPress sites that do not need XML-RPC enabled.

Once activated, the plugin disables XML-RPC and blocks XML-RPC requests with a 403 response. There are no settings to configure and no ongoing maintenance inside wp-admin.

If you are hardening a site and do not rely on XML-RPC-based publishing or integrations, this plugin offers a simple way to turn that functionality off.

= Why site owners install this plugin =

* Disable XML-RPC completely
* Reduce unnecessary exposure on sites that do not use XML-RPC
* Activate once and leave it alone
* No settings page or configuration required
* Minimal plugin footprint

= Important compatibility note =

Do not activate this plugin if your site depends on XML-RPC for publishing tools, apps, or integrations.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/pp-disable-xml-rpc` directory, or install the plugin through the WordPress plugins screen.
2. Activate the plugin through the **Plugins** screen in WordPress.
3. The plugin starts working immediately. No further setup is required.

== Frequently Asked Questions ==

= What does this plugin do? =

It disables WordPress XML-RPC and blocks direct XML-RPC requests.

= Does this plugin have settings? =

No. This plugin is intentionally configuration-free.

= Should I use this on every site? =

Only if the site does not rely on XML-RPC. If any connected service or workflow still uses XML-RPC, disabling it may cause issues.

= Does this replace a full security plugin? =

No. It is a small hardening utility, not a full security suite.

== Changelog ==

= 1.6.1 =
* Current stable release.

== Upgrade Notice ==

= 1.6.1 =
A lightweight release that disables XML-RPC with no configuration required.
