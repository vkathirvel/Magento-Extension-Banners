<?php

/**
 * Optimiseweb Banners Adminhtml Banners Controller
 *
 * @package     Optimiseweb_Banners
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2013 Optimise Web Limited
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Banners_Adminhtml_BannersController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Init ACtion
     */
    protected function _initAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('optimiseweball/banners');
        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Banner Manager'), Mage::helper('adminhtml')->__('Banner Manager'));
        return $this;
    }

    /**
     * Index Action
     */
    public function indexAction()
    {
        $this->_initAction();
        $block = $this->getLayout()->createBlock('banners/adminhtml_banners', 'banners');
        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }

    /**
     * Edit Action
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');

        $model = Mage::getModel('banners/banners')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('banners_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('optimiseweball/banners');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Banner Manager'), Mage::helper('adminhtml')->__('Banner Manager'));
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('banners/adminhtml_banners_edit'));
            $this->_addLeft($this->getLayout()->createBlock('banners/adminhtml_banners_edit_tabs'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('banners')->__('Banner does not exist'));
            $this->_redirect('*/*/');
        }
    }

    /**
     * New Action
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * Save Action
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {

            $model = Mage::getModel('banners/banners');

            /* Store Ids */
            if (!isset($data['store_ids']) OR in_array('0', $data['store_ids'])) {
                $data['store_ids'] = array('0');
            }
            $data['store_ids'] = implode(',', $data['store_ids']);

            /* Image and File Uploads */
            $media_path = Mage::getBaseDir('media') . DS;
            $media_sub_folder = 'optimiseweb/banners' . DS;
            $final_media_path = $media_path . $media_sub_folder;

            $images = array('image', 'image_retina');
            $uploader = '';
            $upload = '';

            foreach ($images as $image) {
                if (isset($_FILES[$image]['name']) && $_FILES[$image]['name'] != '') {
                    if (isset($data[$image]['delete']) && $data[$image]['delete'] == 1) {
                        unlink($media_path . $data[$image]['value']);
                    }
                    $uploader = new Varien_File_Uploader($image);
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(false);
                    $upload = $uploader->save($final_media_path, $_FILES[$image]['name']);
                    $data[$image] = $media_sub_folder . $upload['file'];
                } else {
                    if (isset($data[$image]['delete']) && $data[$image]['delete'] == 1) {
                        unlink($media_path . $data[$image]['value']);
                        $data[$image] = '';
                    } else {
                        if (isset($data[$image]['value'])) {
                            $data[$image] = $data[$image]['value'];
                        } else {
                            $data[$image] = '';
                        }
                    }
                }
                $model->setData($image, $data[$image]);
            }

            /* Dates */
            if ($data['start_date'] == '') {
                $data['start_date'] = NULL;
            } else {
                $date = Mage::app()->getLocale()->date($data['start_date'], Zend_Date::DATE_SHORT);
                $data['start_date'] = $date->toString('YYYY-MM-dd');
            }
            if ($data['end_date'] == '') {
                $data['end_date'] = NULL;
            } else {
                $date1 = Mage::app()->getLocale()->date($data['end_date'], Zend_Date::DATE_SHORT);
                $data['end_date'] = $date1->toString('YYYY-MM-dd');
            }

            /* Save into the model */
            $model->setData($data)->setId($this->getRequest()->getParam('id'));

            try {
                if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                    $model->setCreatedTime(now())->setUpdateTime(now());
                } else {
                    $model->setUpdateTime(now());
                }

                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('banners')->__('Banner was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('banners')->__('Unable to find Banner to save'));
        $this->_redirect('*/*/');
    }

    /**
     * Delete Action
     */
    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('banners/banners');

                /* Delete Images & Files */
                $id = $this->getRequest()->getParam('id');
                $model = Mage::getModel('banners/banners')->load($id);
                if ($model->getId() || $id == 0) {
                    $media_path = Mage::getBaseDir('media') . DS;
                    $images = array('image', 'image_retina');
                    foreach ($images as $image) {
                        unlink($media_path . $model->getData($image));
                    }
                }

                $model->setId($this->getRequest()->getParam('id'))->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Banner was successfully deleted'));
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
     */
    public function massDeleteAction()
    {
        $bannersIds = $this->getRequest()->getParam('banners');
        if (!is_array($bannersIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Banner(s)'));
        } else {
            try {
                foreach ($bannersIds as $bannersId) {
                    $banners = Mage::getModel('banners/banners')->load($bannersId);

                    /* Delete Images & Files */
                    if ($banners->getId()) {
                        $media_path = Mage::getBaseDir('media') . DS;
                        $images = array('image', 'image_retina');
                        foreach ($images as $image) {
                            unlink($media_path . $banners->getData($image));
                        }
                    }

                    $banners->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted', count($bannersIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * Mass Status Action
     */
    public function massStatusAction()
    {
        $bannersIds = $this->getRequest()->getParam('banners');
        if (!is_array($bannersIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Banner(s)'));
        } else {
            try {
                foreach ($bannersIds as $bannersId) {
                    $banners = Mage::getSingleton('banners/banners')
                        ->load($bannersId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($bannersIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * Export CSV
     */
    public function exportCsvAction()
    {
        $fileName = 'banners.csv';
        $content = $this->getLayout()->createBlock('banners/adminhtml_banners_grid')->getCsv();
        $this->_sendUploadResponse($fileName, $content);
    }

    /**
     * Export XML
     */
    public function exportXmlAction()
    {
        $fileName = 'banners.xml';
        $content = $this->getLayout()->createBlock('banners/adminhtml_banners_grid')->getXml();
        $this->_sendUploadResponse($fileName, $content);
    }

    /**
     * Send Upload Response
     */
    protected function _sendUploadResponse($fileName, $content, $contentType = 'application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK', '');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename=' . $fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }

}
