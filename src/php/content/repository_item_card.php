
<div class='accordion-item'>
    <h2 class='accordion-header' id='panelsStayOpen-repository<?php echo $i; ?>'>
        <button class='accordion-button<?php echo $accordion_button; ?>' type='button' data-bs-toggle='collapse'
            data-bs-target='#panelsStayOpen-collapse<?php echo $i; ?>' aria-expanded='<?php echo $expanded; ?>'
            aria-controls='panelsStayOpen-collapse<?php echo $i; ?>'>
            <?php echo $repository_name; ?> <span class='last_update text-secondary ms-2'> <?php echo $repo->getTagsCount(); ?>tag(s) - Last updated <strong><?php  echo $mostRecentTag->getDateTimeDiffAsDays();?> </strong>ago </span>
        </button>
    </h2>
    <div id='panelsStayOpen-collapse<?php echo $i; ?>' class='accordion-collapse collapse <?php echo $accordion_collapse; ?>'
        aria-labelledby='panelsStayOpen-repository<?php echo $i; ?>'>
        <div class='accordion-body'>

            <div class='repository_description'>
                <?php $mostRecentTag->getLabels()->getDescription(); ?>
            </div>

            <div class='repository_options row'>

                <ul class='repository_arch_list col-6'>

                    <?php echo $architectures; ?>
                    
                </ul>

                <div class='row repository_buttons col-6'>

                    <div class="d-flex justify-content-end">
                        <a class='repository_commit btn btn-outline-secondary me-1' href='<?php echo $commit_link; ?>'>
                            <p class='commit_link' style='margin-bottom: 0px'>
                                <span>
                                    <svg class='img_github me-2' xmlns='http://www.w3.org/2000/svg'
                                        viewBox='0 0 496 512'>
                                        <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d='M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3.3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5.3-6.2 2.3zm44.2-1.7c-2.9.7-4.9 2.6-4.6 4.9.3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3.7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3.3 2.9 2.3 3.9 1.6 1 3.6.7 4.3-.7.7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3.7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3.7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z' />
                                    </svg>
                                </span>
                                Last Commit
                            </p>
                        </a>

                        <a href='tags.php?repo=<?php echo $repository_name; ?>' class='repository_open btn btn-primary me-1'>
                            Open
                        </a>

                        <a href="../../../src/php/content/delete.php?repo=<?php echo $repository_name; ?>&action=deleteRepositoryTags" class="delete_repo_button btn btn-danger">
                            <svg width="12" height="12" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.646447 0.646447C0.841709 0.451184 1.15829 0.451184 1.35355 0.646447L4 3.29289L6.64645 0.646447C6.84171 0.451184 7.15829 0.451184 7.35355 0.646447C7.54882 0.841709 7.54882 1.15829 7.35355 1.35355L4.70711 4L7.35355 6.64645C7.54882 6.84171 7.54882 7.15829 7.35355 7.35355C7.15829 7.54882 6.84171 7.54882 6.64645 7.35355L4 4.70711L1.35355 7.35355C1.15829 7.54882 0.841709 7.54882 0.646447 7.35355C0.451184 7.15829 0.451184 6.84171 0.646447 6.64645L3.29289 4L0.646447 1.35355C0.451184 1.15829 0.451184 0.841709 0.646447 0.646447Z" fill="white"/>
                            </svg>
                        <a/>
                    
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>