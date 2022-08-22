<tr class=''>
    <td><a href='tag_page.php?tag=<?php echo $currentTag->getName(); ?>&repo=<?php echo $_GET['repo']; ?>&arch=<?php echo $current_arch; ?>' class='commit_digest'><?php echo substr($current_digest,0,10); ?></a></td>
    <td><span class='os_span'><?php echo $current_os; ?></span> / <span class='arch_span'><?php echo $current_arch; ?></span></td>
    <td><span class='size'><?php echo $current_size; ?> KB</td>
    <td class="d-flex">
        <span class='access_image me-2'>
            <a href='commands.php?tag=<?php echo $currentTag->getName(); ?>&repo=<?php echo $_GET['repo']; ?>&arch=<?php echo $current_arch; ?>' class='btn btn-sm btn-primary'>
                Open
            </a>
        </span>
        <span class="delete_tag">
            <a href="../../../src/php/content/delete.php?repo=<?php echo $_GET['repo']; ?>&tag=<?php echo $currentTag->getName() ?>&action=deleteTag" class="btn btn-sm btn-danger delete_tag_button">
                Delete
            </a>
        </span>
    </td>
</tr>