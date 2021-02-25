=== WPSSO Ratings and Reviews ===
Plugin Name: WPSSO Ratings and Reviews
Plugin Slug: wpsso-ratings-and-reviews
Text Domain: wpsso-ratings-and-reviews
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Assets URI: https://surniaulula.github.io/wpsso-ratings-and-reviews/assets/
Tags: star rating, aggregate rating, review, google, schema, comment, knowledge graph, product rating, product review, meta tags, schema review, schema markup, woocommerce
Contributors: jsmoriss
Requires PHP: 7.0
Requires At Least: 4.5
Tested Up To: 5.6.2
WC Tested Up To: 5.0.0
Stable Tag: 2.13.1

Ratings and Reviews for WordPress Comments with Schema Aggregate Rating and Schema Review Markup.

== Description ==

<p><img class="readme-icon" src="https://surniaulula.github.io/wpsso-ratings-and-reviews/assets/icon-256x256.png"> <strong>Compatible with WooCommerce product ratings and reviews.</strong></p>

**Extends the WordPress comment system with ratings and reviews:**

* Star ratings can be enabled/disabled by post type or individual post.

* A rating value can be required (or not) before reviews are accepted.

* The review form is correctly labeled as a "Review".

* The review reply form is correctly labeled as a "Reply".

* The color of star ratings can be customized from the settings page.

**Provides [Schema Aggregate Rating](https://schema.org/aggregateRating) meta tags and optional JSON-LD markup:**

Google reads aggregate rating meta tags, or the optional Schema JSON-LD markup, to add star ratings to search results (the WPSSO Schema JSON-LD Markup add-on is required for JSON-LD markup).

**Includes complete [Schema Review](https://schema.org/Review) in the optional JSON-LD markup:**

Including information about the review (author name, creation time, excerpt, rating), along with the threaded replies / comments for each review (the [WPSSO JSON Premium add-on](https://wpsso.com/extend/plugins/wpsso-schema-json-ld/) is required for the optional JSON-LD markup).

<h3>No templates to modify or update!</h3>

Simply activate / deactivate the plugin to enable / disable the addition of ratings and reviews.

<h3>WPSSO Core Plugin Required</h3>

WPSSO Ratings and Reviews (aka WPSSO RAR) is an add-on for the [WPSSO Core plugin](https://wordpress.org/plugins/wpsso/). WPSSO Core and its add-ons make sure your content looks best on social sites and in search results, no matter how webpages are shared, re-shared, messaged, posted, embedded, or crawled.

== Installation ==

<h3 class="top">Install and Uninstall</h3>

* [Install the WPSSO Ratings and Reviews add-on](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/installation/install-the-plugin/).
* [Uninstall the WPSSO Ratings and Reviews add-on](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/installation/uninstall-the-plugin/).

== Frequently Asked Questions ==

<h3 class="top">Frequently Asked Questions</h3>

* None.

<h3>Notes and Documentation</h3>

* [Developer Resources](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/notes/developer/)
	* [Get Average Rating](https://wpsso.com/docs/plugins/wpsso-ratings-and-reviews/notes/developer/get-average-rating/)

== Screenshots ==

01. The WPSSO RAR settings page to enable ratings by post type and select colors for the star ratings. 
02. The WPSSO RAR review submission &mdash; note the customized labels (Your Rating, Your Review, etc.).

== Changelog ==

<h3 class="top">Version Numbering</h3>

Version components: `{major}.{minor}.{bugfix}[-{stage}.{level}]`

* {major} = Major structural code changes / re-writes or incompatible API changes.
* {minor} = New functionality was added or improved in a backwards-compatible manner.
* {bugfix} = Backwards-compatible bug fixes or small improvements.
* {stage}.{level} = Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).

<h3>Standard Version Repositories</h3>

* [GitHub](https://surniaulula.github.io/wpsso-ratings-and-reviews/)
* [WordPress.org](https://plugins.trac.wordpress.org/browser/wpsso-ratings-and-reviews/)

<h3>Changelog / Release Notes</h3>

**Version 2.13.1 (2021/02/25)**

* **New Features**
	* None.
* **Improvements**
	* Updated the banners and icons of WPSSO Core and its add-ons.
* **Bugfixes**
	* None.
* **Developer Notes**
	* None.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v4.5.
	* WPSSO Core v8.23.0.

**Version 2.13.0 (2021/01/21)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Changed `jQuery( document ).on( 'ready' )` event handlers to `jQuery()` for jQuery v3.0.
	* Renamed 'get_og_type_reviews()' to 'get_mt_reviews()' for WPSSO v8.20.0.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v4.5.
	* WPSSO Core v8.20.0.

**Version 2.12.0 (2020/12/04)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Included the `$addon` argument for library class constructors.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v4.5.
	* WPSSO Core v8.16.0.

**Version 2.11.1 (2020/10/17)**

* **New Features**
	* None.
* **Improvements**
	* Refactored the add-on class to extend a new WpssoAddOn abstract class.
* **Bugfixes**
	* Fixed backwards compatibility with older 'init_objects' and 'init_plugin' action arguments.
* **Developer Notes**
	* Added a new WpssoAddOn class in lib/abstracts/add-on.php.
	* Added a new SucomAddOn class in lib/abstracts/com/add-on.php.
* **Requires At Least**
	* PHP v5.6.
	* WordPress v4.4.
	* WPSSO Core v8.13.0.

== Upgrade Notice ==

= 2.13.1 =

(2021/02/25) Updated the banners and icons of WPSSO Core and its add-ons.

= 2.13.0 =

(2021/01/21) Changed `jQuery( document ).on( 'ready' )` event handlers to `jQuery()` for jQuery v3.0.

= 2.12.0 =

(2020/12/04) Included the `$addon` argument for library class constructors.

= 2.11.1 =

(2020/10/17) Refactored the add-on class to extend a new WpssoAddOn abstract class.

