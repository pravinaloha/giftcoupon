<?php
/**
 * Video Gallery 
 *
 * @category   Gallery
 * @package    Gallery_Video
 */
class Gallery_Video_Adminhtml_videoController extends Mage_Adminhtml_Controller_action
{
	/**
	 * Init Action
	 * @param null
	 * @return unknown
	 *
	 **/
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('video/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
    
    public function test(){
        echo 'Hello World';
    }
 
 	/**
	 * Index Action
	 * @param null
	 * @return unknown
	 *
	 **/
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	/**
	 * Edit Action
	 * @param null
	 * @return unknown
	 *
	 **/
	public function editAction() 
	{
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('video/video')->load($id);
		
		// Check if Id exists then only edit
		if ($model->getId() || $id == 0) {

			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
				//if($model->save() == true) { echo 'yes' ;} exit;	
			Mage::register('video_data', $model);
			
			$this->loadLayout();
			$this->_setActiveMenu('video/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('video/adminhtml_video_edit'))
				->_addLeft($this->getLayout()->createBlock('video/adminhtml_video_edit_tabs'));

			$this->renderLayout();
		} else {

			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('video')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
 	/**
	 * New Action
	 * @param null
	 * @return unknown
	 *
	 **/
	public function newAction() {
		$this->_forward('edit');
	}
 
 	/**
	 * Save Action
	 * @param null
	 * @return unknown
	 *
	 **/
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			 if(isset($data['stores'])) {
				  $stores = $data['stores'];
				  $storesCount = count($stores);
				  $storesIndex = 1;
				  $storesData = '';

		          foreach($stores as $store) {
						$storesData .= $store;
				           if($storesIndex < $storesCount) {
								$storesData .= ',';
				           }
						$storesIndex++;
		          }

				$data['store_view'] = $storesData;
	         } 

			if(isset($data['small_image']['delete'])	&&	$data['small_image']['delete']	==	1)	{
				$source_dir	=	Mage::getBaseDir('media')	.	DS	.	$data['small_image']['value'];											
				chmod($source_dir, 0777);
				unlink($source_dir);
				$data['small_image']	=	'';
			}
			elseif(isset($data['small_image'])	&&	is_array($data['small_image']))	{
				$data['small_image']	=	$data['small_image']['value'];
			
			}	

			// CHeck for delete actions
			for($i = 1; $i<=10; $i++)	
			{

				if(isset($data['full_image'.$i]['delete'])	&&	$data['full_image'.$i]['delete']	==	1)	{
					$source_dir	=	Mage::getBaseDir('media')	.	DS	.	$data['full_image'.$i]['value'];											
					chmod($source_dir, 0777);
					unlink($source_dir);
					$data['full_image'.$i]	=	'';
				}
				elseif(isset($data['full_image'.$i])	&&	is_array($data['full_image'.$i]))	{
					$data['full_image'.$i]	=	$data['full_image'.$i]['value'];
				
				}	

			}
				
			// Upload small Images

			if(isset($_FILES['small_image']['name']) && $_FILES['small_image']['name'] != '') {
				try {	
					$uploaderSmall = new Varien_File_Uploader('small_image');					
					$uploaderSmall->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploaderSmall->setAllowRenameFiles(false);
					$uploaderSmall->setFilesDispersion(false);						
					$pathSmall = Mage::getBaseDir('media') . DS . "videoImages" . DS . "small" . DS;
					
					$uploaderSmall->save($pathSmall, $_FILES['small_image']['name'] );						
					
					$data['small_image'] = 'videoImages/small/' . $_FILES['small_image']['name']; // $_FILES['small_image']['name'];						
					//echo $data['small_image'];
					//exit;
						
				} catch (Exception $e) {
					Mage::getSingleton('adminhtml/session')->setFormData($this->getRequest()->getPost());
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('video')->__('Unable to upload images.'));
					$this->_redirect('*/*/');
				}
			}

			// Upload Full Images

			for($i = 1; $i<=10; $i++)	
			{

				if(isset($_FILES['full_image'.$i]['name']) && $_FILES['full_image'.$i]['name'] != '') {
					try {	
						$uploaderSmall = new Varien_File_Uploader('full_image'.$i);					
						$uploaderSmall->setAllowedExtensions(array('jpg','jpeg','gif','png'));
						$uploaderSmall->setAllowRenameFiles(false);
						$uploaderSmall->setFilesDispersion(false);						
						$pathSmall = Mage::getBaseDir('media') . DS . "videoImages" . DS . "full_image" . DS;
						
						$uploaderSmall->save($pathSmall, $_FILES['full_image'.$i]['name'] );						
						
						$data['full_image'.$i] = 'videoImages/full_image/' . $_FILES['full_image'.$i]['name']; // $_FILES['small_image']['name'];						
						//echo $data['small_image'];
						//exit;
							
					} catch (Exception $e) {
						Mage::getSingleton('adminhtml/session')->setFormData($this->getRequest()->getPost());
						Mage::getSingleton('adminhtml/session')->addError(Mage::helper('video')->__('Unable to upload images.'));
						$this->_redirect('*/*/');
					}
				}

			}

			$model = Mage::getModel('video/video');
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
				
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
			
				$year = $this->getRequest()->getPost('year');
				$model->setYear($year); 
				$model->save();
				
					
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('video')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('video')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
 	/**
	 * Delete Action
	 * @param null
	 * @return unknown
	 *
	 **/
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('video/video');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

	/**
	 * Mass Delete Action
	 * @param null
	 * @return unknown
	 *
	 **/
    public function massDeleteAction() {
        $videoIds = $this->getRequest()->getParam('video');
        if(!is_array($videoIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($videoIds as $videoId) {
                    $video = Mage::getModel('video/video')->load($videoId);
                    $video->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('adminhtml')->__(
                    'Total of %d record(s) were successfully deleted', count($videoIds)
                ));
                
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
	/**
	 * Mask Status changes action
	 * @param null
	 * @return unknown
	 *
	 **/
    public function massStatusAction()
    {
        $videoIds = $this->getRequest()->getParam('video');
        if(!is_array($videoIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($videoIds as $videoId) {
                    $video = Mage::getSingleton('video/video')
                        ->load($videoId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($videoIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
  	/**
	 * Function to Export CSV
	 * @param null
	 * @return unknown
	 *
	 **/
    public function exportCsvAction()
    {
        $fileName   = 'video.csv';
        $content    = $this->getLayout()->createBlock('video/adminhtml_video_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    /**
	 * Function to export XML
	 * @param null
	 * @return unknown
	 *
	 **/
    public function exportXmlAction()
    {
        $fileName   = 'video.xml';
        $content    = $this->getLayout()->createBlock('video/adminhtml_video_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    /**
	 * Function to render xml or csv
	 * @param null
	 * @return unknown
	 *
	 **/
    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}
