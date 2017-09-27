          
                                        <?php $aboutlist = plugin('article_list', 'photography', 4, 3); ?>
                                    <div class="wrap-col">
                                        <h6>相关文章:</h6>
                                        <div class="wrapper hr-border-1">

                                        <?php if (is_array($aboutlist['list'])): foreach ($aboutlist['list'] as $al): ?>
                                            <div class="extra-wrap pad-top">
                                                <p class="p0">
                                                    <strong class="str-1">
                                                    <a href="<?=$al['link']?>"><?=$al['title']?></a> 
                                                    </strong>
                                                </p>
                                                <p class="p2">
                                    		 <?=$al['intro_content']?>

                                                </p>
                                            </div>
                                        </div>
                                        
                                              <?php 
                                            endforeach;
                                            endif; 
                                            ?> 
                             
                                   
                                        <p class="p1 color-1">
                                            <i>
                                	成都雪山之梦户外运动有限公司是一家专门从事户外运动和户外体验的专业机构。本机构以四川阿坝州四姑娘山为基地，拥有得天独厚的户外扩展基地和训练基地.欢迎您的加入
                                            </i>
                                        </p>

                                    </div>