fos.Router.setData({"base_url":"","routes":{"cms_back_index":{"tokens":[["text","\/administration"]],"defaults":[],"requirements":[],"hosttokens":[]},"cms_back_home":{"tokens":[["text","\/administration\/home"]],"defaults":[],"requirements":[],"hosttokens":[]},"cms_page_list":{"tokens":[["text","\/administration\/pages"]],"defaults":[],"requirements":[],"hosttokens":[]},"cms_page_new":{"tokens":[["text","\/administration\/page"]],"defaults":[],"requirements":[],"hosttokens":[]},"cms_page_edit":{"tokens":[["variable","\/","\\d+","pageId"],["text","\/administration\/page"]],"defaults":[],"requirements":{"pageId":"\\d+"},"hosttokens":[]},"cms_post_list":{"tokens":[["text","\/administration\/posts"]],"defaults":[],"requirements":[],"hosttokens":[]},"cms_post_new":{"tokens":[["text","\/administration\/post"]],"defaults":[],"requirements":[],"hosttokens":[]},"cms_post_edit":{"tokens":[["variable","\/","\\d+","postId"],["text","\/administration\/post"]],"defaults":[],"requirements":{"postId":"\\d+"},"hosttokens":[]},"cms_block_list":{"tokens":[["text","\/administration\/blocks"]],"defaults":[],"requirements":[],"hosttokens":[]},"cms_block_new":{"tokens":[["text","\/administration\/block"]],"defaults":[],"requirements":[],"hosttokens":[]},"cms_block_edit":{"tokens":[["variable","\/","[^\/]++","blockId"],["text","\/administration\/block"]],"defaults":[],"requirements":{"postId":"\\d+"},"hosttokens":[]},"cms_page_view":{"tokens":[["variable","\/","[^\/]++","pagePath"],["text","\/page"]],"defaults":[],"requirements":[],"hosttokens":[]},"cms_page_index":{"tokens":[["text","\/pages"]],"defaults":[],"requirements":[],"hosttokens":[]},"cms_post_index":{"tokens":[["text","\/posts"]],"defaults":[],"requirements":[],"hosttokens":[]},"cms_post_view":{"tokens":[["variable","\/","\\d+","postId"],["text","\/post"]],"defaults":[],"requirements":{"postId":"\\d+"},"hosttokens":[]},"cms_post_preview":{"tokens":[["variable","\/","\\d+","postId"],["text","\/preview\/post"]],"defaults":[],"requirements":{"postId":"\\d+"},"hosttokens":[]},"cms_media_download":{"tokens":[["variable","\/","\\d+","id"],["text","\/media"]],"defaults":[],"requirements":{"id":"\\d+"},"hosttokens":[]},"cms_rest":{"tokens":[["text","\/rest\/"]],"defaults":[],"requirements":[],"hosttokens":[]},"cms_rest_page_delete_page":{"tokens":[["variable","\/","[^\/]++","pageRoute"],["text","\/rest\/pages"]],"defaults":[],"requirements":{"_method":"DELETE"},"hosttokens":[]},"cms_rest_page_get_page":{"tokens":[["variable","\/","[^\/]++","pageRoute"],["text","\/rest\/pages"]],"defaults":[],"requirements":{"_method":"GET"},"hosttokens":[]},"cms_rest_page_get_page_all":{"tokens":[["text","\/rest\/page\/all"]],"defaults":[],"requirements":{"_method":"GET"},"hosttokens":[]},"cms_rest_page_get_page_all_active":{"tokens":[["text","\/rest\/page\/all\/active"]],"defaults":[],"requirements":{"_method":"GET"},"hosttokens":[]},"cms_rest_page_post_page":{"tokens":[["text","\/rest\/pages"]],"defaults":[],"requirements":{"_method":"POST"},"hosttokens":[]},"cms_rest_page_put_page":{"tokens":[["variable","\/","[^\/]++","pageRoute"],["text","\/rest\/pages"]],"defaults":[],"requirements":{"_method":"PUT"},"hosttokens":[]},"cms_rest_publication_status_get_publicationstatus":{"tokens":[["variable","\/","[^\/]++","publicationStatus"],["text","\/rest\/publicationstatuses"]],"defaults":[],"requirements":{"_method":"GET"},"hosttokens":[]},"cms_rest_publication_status_get_publicationstatus_all":{"tokens":[["text","\/rest\/publicationstatus\/all"]],"defaults":[],"requirements":{"_method":"GET"},"hosttokens":[]},"cms_rest_post_delete_post":{"tokens":[["variable","\/","[^\/]++","post"],["text","\/rest\/posts"]],"defaults":[],"requirements":{"_method":"DELETE"},"hosttokens":[]},"cms_rest_post_get_post":{"tokens":[["variable","\/","[^\/]++","post"],["text","\/rest\/posts"]],"defaults":[],"requirements":{"_method":"GET"},"hosttokens":[]},"cms_rest_post_get_post_available_categories":{"tokens":[["text","\/rest\/post\/available\/categories"]],"defaults":[],"requirements":{"_method":"GET"},"hosttokens":[]},"cms_rest_post_get_post_all":{"tokens":[["text","\/rest\/post\/all"]],"defaults":[],"requirements":{"_method":"GET"},"hosttokens":[]},"cms_rest_post_get_post_all_active":{"tokens":[["text","\/rest\/post\/all\/active"]],"defaults":[],"requirements":{"_method":"GET"},"hosttokens":[]},"cms_rest_post_get_post_category":{"tokens":[["text","\/category"],["variable","\/","[^\/]++","category"],["text","\/rest\/posts"]],"defaults":[],"requirements":{"_method":"GET"},"hosttokens":[]},"cms_rest_post_post_post":{"tokens":[["text","\/rest\/posts"]],"defaults":[],"requirements":{"_method":"POST"},"hosttokens":[]},"cms_rest_post_put_post":{"tokens":[["variable","\/","[^\/]++","post"],["text","\/rest\/posts"]],"defaults":[],"requirements":{"_method":"PUT"},"hosttokens":[]},"cms_rest_block_delete_block":{"tokens":[["variable","\/","[^\/]++","block"],["text","\/rest\/blocks"]],"defaults":[],"requirements":{"_method":"DELETE"},"hosttokens":[]},"cms_rest_block_get_block":{"tokens":[["variable","\/","[^\/]++","block"],["text","\/rest\/blocks"]],"defaults":[],"requirements":{"_method":"GET"},"hosttokens":[]},"cms_rest_block_get_block_all":{"tokens":[["text","\/rest\/block\/all"]],"defaults":[],"requirements":{"_method":"GET"},"hosttokens":[]},"cms_rest_block_post_block":{"tokens":[["text","\/rest\/blocks"]],"defaults":[],"requirements":{"_method":"POST"},"hosttokens":[]},"cms_rest_block_put_block":{"tokens":[["variable","\/","[^\/]++","block"],["text","\/rest\/blocks"]],"defaults":[],"requirements":{"_method":"PUT"},"hosttokens":[]},"cms_rest_media_get_media_all":{"tokens":[["text","\/rest\/media\/all"]],"defaults":[],"requirements":{"_method":"GET"},"hosttokens":[]},"cms_rest_media_post_media":{"tokens":[["text","\/rest\/media"]],"defaults":[],"requirements":{"_method":"POST"},"hosttokens":[]},"cms_rest_media_put_media":{"tokens":[["variable","\/","[^\/]++","mediaId"],["text","\/rest\/media"]],"defaults":[],"requirements":{"_method":"PUT"},"hosttokens":[]},"cms_rest_media_delete_media":{"tokens":[["variable","\/","[^\/]++","media"],["text","\/rest\/media"]],"defaults":[],"requirements":{"_method":"DELETE"},"hosttokens":[]},"cms_rest_media_post_media_edit":{"tokens":[["text","\/edits"],["variable","\/","[^\/]++","media"],["text","\/rest\/media"]],"defaults":[],"requirements":{"_method":"POST"},"hosttokens":[]},"bazinga_jstranslation_js":{"tokens":[["variable",".","js|json","_format"],["variable","\/","[\\w]+","domain"],["text","\/translations"]],"defaults":{"domain":"messages","_format":"js"},"requirements":{"_format":"js|json","domain":"[\\w]+","_method":"GET"},"hosttokens":[]}},"prefix":"","host":"localhost","scheme":"http"});