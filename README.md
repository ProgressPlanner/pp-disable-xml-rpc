# Disable XML-RPC by ProgressPlanner

![Disable XML-RPC](.wordpress.org/github_banner_disable_xml_rcp_pp.png)

XML-RPC requests receive HTTP 403 and stop when this plugin loads. Some WordPress
bootstrap work has already happened at that point. For protection against request
floods, block `xmlrpc.php` at your web server or edge before PHP runs.

Releases are deployed by pushing a `v*` tag. The repository's active release-tag
ruleset restricts creating, changing, and deleting these tags to repository admins.
Review the tagged commit before pushing it. The GitHub release is created only
after the WordPress.org deployment succeeds.

Playground previews use nightly.link to serve the workflow artifact publicly.
Use them only as disposable test sites without production credentials or private
data. Fork and Dependabot PRs still upload artifacts but skip posting comments
because their workflow tokens cannot write PR comments.

Run the plugin regression checks with:

```sh
for scenario in direct xmlrpc normal false; do
  php tests/plugin.php "$scenario" || exit 1
done
```
