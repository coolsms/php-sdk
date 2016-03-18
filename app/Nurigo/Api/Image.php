<?php
/* vi:set sw=4 ts=4 expandtab: */

namespace Nurigo\Api;

use Nurigo\Coolsms;
use Nurigo\Exceptions\CoolsmsSDKException;

require_once __DIR__ . "/../../../vendor/autoload.php";

/**
 * @class Image
 * @brief management image, using Rest API
 */
class Image extends Coolsms
{
    /**
     * @brief get image list( HTTP Method GET )
     * @param $options (options can be optional)
     * @param offset, limit (optional)
     * @return object(total_count, offset, limit, list['image_id', 'image_id' ...])
     */
    public function imageList($offset = null, $limit = null) 
    {
        $options = new \stdClass();
        $options->offset = $offset;
        $options->limit = $limit;
        $this->setMethod('image_list');
        $this->addInfos($options);
        return $this->getResult();
    }

    /**
     * @brief get image info ( HTTP Method GET )
     * @param $image_id (required)
     * @return object(image_id, file_name, original_name, file_size, width, height)
     */
    public function imageInfo($iamge_id) 
    {
        if (!$iamge_id) throw new CoolsmsSDKException('image_id is required',202);

        $options = new \stdClass();
        $options->image_id = $image_id;
        $this->setMethod('images/' . $image_id);
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @brief upload image ( HTTP Method POST )
     * @param $image (required)
     * @param $encoding (optional)
     * @return object(image_id)
     */
    public function uploadImage($image, $encoding = null)
    {
        if (!$image) throw new CoolsmsSDKException('image is required',202);

        $options = new \stdClass();
        $options->image = $image;
        $options->encoding = $encoding;
        $this->setMethod('upload_image', 1);
        $this->addInfos($options);    
        return $this->getResult();
    }

    /**
     * @brief delete images ( HTTP Method POST )
     * @param $image_ids (required)
     * @return object(success_count)
     */
    public function deleteImages($image_ids) 
    {
        if (!$image_ids) throw new CoolsmsSDKException('image_ids is required',202);

        $options = new \stdClass();
        $options->image_ids = $image_ids;
        $this->setMethod('delete_images', 1);
        $this->addInfos($options);    
        return $this->getResult();
    }
}
