fos.Router.setData({"base_url":"","routes":{"cms_media_download":{"tokens":[["text","\/media\/download"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"cms_rest":{"tokens":[["text","\/rest\/"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"cms_rest_page_delete_page":{"tokens":[["variable","\/","[^\/]++","pageRoute"],["text","\/rest\/pages"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["DELETE"],"schemes":[]},"cms_rest_page_get_page":{"tokens":[["variable","\/","[^\/]++","pageRoute"],["text","\/rest\/pages"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["GET"],"schemes":[]},"cms_rest_page_get_page_all":{"tokens":[["text","\/rest\/page\/all"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["GET"],"schemes":[]},"cms_rest_page_get_page_all_active":{"tokens":[["text","\/rest\/page\/all\/active"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["GET"],"schemes":[]},"cms_rest_page_post_page":{"tokens":[["text","\/rest\/pages"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["POST"],"schemes":[]},"cms_rest_page_put_page":{"tokens":[["variable","\/","[^\/]++","pageRoute"],["text","\/rest\/pages"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["PUT"],"schemes":[]},"cms_rest_publication_status_get_publicationstatus":{"tokens":[["variable","\/","[^\/]++","publicationStatus"],["text","\/rest\/publicationstatuses"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["GET"],"schemes":[]},"cms_rest_publication_status_get_publicationstatus_all":{"tokens":[["text","\/rest\/publicationstatus\/all"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["GET"],"schemes":[]},"cms_rest_post_delete_post":{"tokens":[["variable","\/","[^\/]++","post"],["text","\/rest\/posts"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["DELETE"],"schemes":[]},"cms_rest_post_get_post":{"tokens":[["variable","\/","[^\/]++","post"],["text","\/rest\/posts"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["GET"],"schemes":[]},"cms_rest_post_get_post_available_categories":{"tokens":[["text","\/rest\/post\/available\/categories"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["GET"],"schemes":[]},"cms_rest_post_get_post_all":{"tokens":[["text","\/rest\/post\/all"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["GET"],"schemes":[]},"cms_rest_post_get_post_all_active":{"tokens":[["text","\/rest\/post\/all\/active"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["GET"],"schemes":[]},"cms_rest_post_get_post_category":{"tokens":[["text","\/category"],["variable","\/","[^\/]++","category"],["text","\/rest\/posts"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["GET"],"schemes":[]},"cms_rest_post_post_post":{"tokens":[["text","\/rest\/posts"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["POST"],"schemes":[]},"cms_rest_post_put_post":{"tokens":[["variable","\/","[^\/]++","post"],["text","\/rest\/posts"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["PUT"],"schemes":[]},"cms_rest_block_delete_block":{"tokens":[["variable","\/","[^\/]++","block"],["text","\/rest\/blocks"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["DELETE"],"schemes":[]},"cms_rest_block_get_block":{"tokens":[["variable","\/","[^\/]++","block"],["text","\/rest\/blocks"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["GET"],"schemes":[]},"cms_rest_block_get_block_all":{"tokens":[["text","\/rest\/block\/all"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["GET"],"schemes":[]},"cms_rest_block_post_block":{"tokens":[["text","\/rest\/blocks"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["POST"],"schemes":[]},"cms_rest_block_put_block":{"tokens":[["variable","\/","[^\/]++","block"],["text","\/rest\/blocks"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["PUT"],"schemes":[]},"cms_rest_media_get_media_all":{"tokens":[["text","\/rest\/media\/all"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["GET"],"schemes":[]},"cms_rest_media_post_media":{"tokens":[["text","\/rest\/media"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["POST"],"schemes":[]},"cms_rest_media_put_media":{"tokens":[["variable","\/","[^\/]++","mediaId"],["text","\/rest\/media"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["PUT"],"schemes":[]},"cms_rest_media_delete_media":{"tokens":[["variable","\/","[^\/]++","media"],["text","\/rest\/media"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["DELETE"],"schemes":[]},"cms_rest_media_post_media_edit":{"tokens":[["text","\/edits"],["variable","\/","[^\/]++","media"],["text","\/rest\/media"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["POST"],"schemes":[]},"bazinga_jstranslation_js":{"tokens":[["variable",".","js|json","_format"],["variable","\/","[\\w]+","domain"],["text","\/translations"]],"defaults":{"domain":"messages","_format":"js"},"requirements":{"_format":"js|json","domain":"[\\w]+"},"hosttokens":[],"methods":["GET"],"schemes":[]}},"prefix":"","host":"localhost","scheme":"http"});