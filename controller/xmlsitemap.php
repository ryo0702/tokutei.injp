<?php
header("Content-Type: application/xml; charset=UTF-8");

include get_template_directory().'/array_common.php';
$site_url = site_url();
$insert_pref = null;

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<?xml-stylesheet type="text/xsl" href="/tokutei.injp/wp-content/plugins/xml-sitemap-feed/assets/sitemap-posttype.xsl?ver=5.3.3"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
		http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd
		http://www.google.com/schemas/sitemap-image/1.1
		http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd">';

      echo '<url>
         <loc>'.$site_url.'</loc>
         <priority>1.0</priority>
         <lastmod>'.date('Y-m-d').'</lastmod>
      </url>';

      echo '<url>
         <loc>'.$site_url.'/?pagetype=estimate_result</loc>
         <priority>0.8</priority>
         <lastmod>'.date('Y-m-d').'</lastmod>
      </url>';
      
      foreach ($array_pref_group as $array_area) {
         foreach ($array_area as $pref) {
            echo '<url>
               <loc>'.$site_url.'/?pagetype=estimate_result&amp;pref='.$pref.'</loc>
               <priority>0.5</priority>
               <lastmod>'.date('Y-m-d').'</lastmod>
            </url>';
         }
      }

      echo '<url>
         <loc>'.$site_url.'/?pagetype=about_seido</loc>
         <priority>0.5</priority>
         <lastmod>'.date('Y-m-d').'</lastmod>
      </url>';

      echo '<url>
         <loc>'.$site_url.'/?pagetype=about_kanridantai</loc>
         <priority>0.5</priority>
         <lastmod>'.date('Y-m-d').'</lastmod>
      </url>';
      
      echo '<url>
         <loc>'.$site_url.'/?pagetype=about_okuridashi</loc>
         <priority>0.5</priority>
         <lastmod>'.date('Y-m-d').'</lastmod>
      </url>';

      echo '<url>
         <loc>'.$site_url.'/?pagetype=rule</loc>
         <priority>0.1</priority>
         <lastmod>'.date('Y-m-d').'</lastmod>
      </url>';

      echo '<url>
         <loc>'.$site_url.'/?pagetype=company</loc>
         <priority>0.1</priority>
         <lastmod>'.date('Y-m-d').'</lastmod>
      </url>';

echo '</urlset>';