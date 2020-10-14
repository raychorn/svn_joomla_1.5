<?php
/** Template by Ryan de Mulder for www.gameon.be */
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">
<head>
<jdoc:include type="head" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template.css" type="text/css" />
<!--[if lte IE 6]>
<style type="text/css">
#gomenu li ul { display: none; }
.titlegoright { display: none; }
</style>
<![endif]-->
</head>
<body>

	<div id="wrap" class="tripleborder">
        <div class="lightcolor wrappadding">
            <span class="invisible">Template by <a href="mailto:Ryan.deMulder@gameon.be">Ryan de Mulder</a> for <a href="http://www.gameon.be">www.gameon.be</a></span> <!-- this is invisible, so please don't remove this, it doesn't bother you -->
            <div id="top">
                <div class="shadowtopleft">
                    <div class="shadowtopright">
                        <div class="shadowtop"></div>
                    </div>
                </div>
                <div class="shadowleft">
                    <div class="shadowright">
                        <div class="shadowcontent shadowcolor2">
                            <div id="header">
                                <?php if ($this->countModules('user1')) : ?>
                                <div id="gomenu">
                                    <jdoc:include type="modules" name="user1" style="xhtml" /> <!-- own drop-down menu, in menu settings, set 'always show sub-menu's' to 'yes' and 'show title' to 'no' -->
                                </div>
                                <?php endif; ?>
                                <?php if ($this->countModules('user2')) : ?>
                                <div id="banner">
                                    <jdoc:include type="modules" name="user2" style="xhtml" /> <!-- anything here (banner) -->
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="shadowbottomleft">
                    <div class="shadowbottomright">
                        <div class="shadowbottom"></div>
                    </div>
                </div>
            </div>
    
            <div id="middle">
                <div class="shadowtopleft">
                    <div class="shadowtopright">
                        <div class="shadowtop"></div>
                    </div>
                </div>
                <div class="shadowleft">
                    <div class="shadowright">
                        <div class="shadowcontent shadowcolor2">
                            <div id="content">
                                <div id="leftcolumn_<?php echo $this->countModules('left')>0; ?>">
                                    <?php if ($this->countModules('left')) : ?>	
                                    <div class="tripleborder stylemenu">
                                        <div class="lightcolor">
                                            <div class="columntitle"><?php echo $this->params->get('leftMenuTitle'); ?></div> <!-- own text -->
                                            <div class="columntitleshadow"></div>
                                            <div class="sidemodules">
                                                <jdoc:include type="modules" name="left" style="xhtml" /> <!-- left module -->
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div id="rightcolumn_<?php echo $this->countModules('right')>0; ?>">
                                    <?php if ($this->countModules('right')) : ?>
                                    <div class="tripleborder stylemenu">
                                        <div class="lightcolor">
                                            <div class="columntitle"><?php echo $this->params->get('rightMenuTitle'); ?></div> <!-- own text -->
                                            <div class="columntitleshadow"></div>
                                            <div class="sidemodules">
                                                <jdoc:include type="modules" name="right" style="xhtml" /> <!-- right module -->
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div id="middlecolumn_<?php echo $this->countModules('left')>0; ?>_<?php echo $this->countModules('right')>0; ?>">
                                    <div class="columntitle tripleborder">
                                        <div class="titlegoleft">
                                            <?php if ($this->params->get('middleMenu')=='breadcrumb') { ?> <!-- breadcrumbs... -->
                                            <jdoc:include type="modules" name="breadcrumb" style="xhtml" />
                                            <?php } else { echo $this->params->get('middleMenuTitle'); } ?> <!-- ... or own text -->
                                            <?php if ($this->countModules('user4')) : ?> <!-- search -->
                                            <div class="titlegoright">
                                                <jdoc:include type="modules" name="user4" style="xhtml" />
                                            </div>
											<?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="columntitleshadow2"></div>
                                    <div id="contain5and6">
                                        <?php if ($this->countModules('user6')) : ?> <!-- user module -->
                                        <div id="user6">
                                            <jdoc:include type="modules" name="user6" style="xhtml" />
                                        </div>
                                        <?php endif; ?>
										<?php if ($this->countModules('user5')) : ?>
                                        <div id="user5">
                                            <jdoc:include type="modules" name="user5" style="xhtml" />
                                        </div>
                                        <?php endif; ?>
                                    </div>
										<?php if ($this->countModules('user3')) : ?> <!-- user module -->
                                        <div id="user3">
                                            <jdoc:include type="modules" name="user3" style="xhtml" />
                                        </div>
                                        <?php endif; ?>
                                        <div id="containrest">
											<jdoc:include type="component" style="xhtml" /> <!-- content -->
											<br /><br /><?php if (file_exists($mosConfig_absolute_path."/components/com_comments/comments.php")) { require_once($mosConfig_absolute_path."/components/com_comments/comments.php"); } ?>
                                    	</div>
                                        <?php if ($this->countModules('user7')) : ?>
                                        <div id="user7">
                                            <jdoc:include type="modules" name="user7" style="xhtml" /> <!-- user module -->
                                        </div>
                                        <?php endif; ?>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="shadowbottomleft">
                    <div class="shadowbottomright">
                        <div class="shadowbottom"></div>
                    </div>
                </div>
            </div>
    
            <div id="bottom">
                <div class="shadowtopleft">
                    <div class="shadowtopright">
                        <div class="shadowtop"></div>
                    </div>
                </div>
                <div class="shadowleft">
                    <div class="shadowright">
                        <div id="footer" class="shadowcontent shadowcolor2">
                            <span>Valid <a href="http://validator.w3.org/check/referer">XHTML</a> and <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a></span><br />
                            <span>Design by <a href="http://www.gameon.be/design" target="_blank">GO designs</a></span>
<!-- Please appreciate the hours of work I put in making this design, and don't remove this line (and definately don't make it look like you created this design, even if you changed a few things around) -->
                            <?php if ($this->countModules('footer')) : ?>
                            <jdoc:include type="modules" name="footer" style="xhtml" /> <!-- footer module -->
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="shadowbottomleft">
                    <div class="shadowbottomright">
                        <div class="shadowbottom"></div>
                    </div>
                </div>
            </div>
            <span class="invisible">Template by <a href="mailto:Ryan.deMulder@gameon.be">Ryan de Mulder</a> for <a href="http://www.gameon.be">www.gameon.be</a></span> <!-- this is invisible, so please don't remove this, it doesn't bother you -->
        </div>
    </div>
    <div id="columntitleshadow2"></div>

</body>
</html>