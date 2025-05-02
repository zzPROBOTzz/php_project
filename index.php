<?php
require_once __DIR__ . '/handlers/AdvertisementHandler.php';
require_once __DIR__ . '/handlers/AuthHandler.php';

$auth = new AuthHandler();
$auth->requireLogin();

$adHandler = new AdvertisementHandler($auth->getCurrentUser());
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$result = $adHandler->handleList($page);

$pageTitle = 'Advertisement System - Home';
ob_start();
?>

<div class="home-container">
    <div class="header-actions">
        <h2>Latest Advertisements</h2>
        <a href="/views/ads/create.php" class="btn btn-primary">Post New Ad</a>
    </div>

    <?php if (empty($result['ads'])): ?>
        <div class="alert alert-info">
            No advertisements available. 
            <a href="/views/ads/create.php">Be the first to post an ad!</a>
        </div>
    <?php else: ?>
        <div class="ads-grid">
            <?php foreach ($result['ads'] as $ad): ?>
                <div class="ad-card">
                    <?php if ($ad['image']): ?>
                        <img src="/uploads/images/<?php echo htmlspecialchars($ad['image']); ?>" 
                             alt="<?php echo htmlspecialchars($ad['title']); ?>" 
                             class="ad-image">
                    <?php endif; ?>
                    
                    <div class="ad-content">
                        <h3><?php echo htmlspecialchars($ad['title']); ?></h3>
                        <p class="price">$<?php echo number_format($ad['price'], 2); ?></p>
                        <p class="description"><?php echo htmlspecialchars(substr($ad['description'], 0, 100)) . '...'; ?></p>
                        
                        <?php 
                        $currentUser = $auth->getCurrentUser();
                        if (isset($currentUser['id']) && $ad['user_id'] === $currentUser['id']): 
                        ?>
                            <div class="ad-actions">
                                <a href="/views/ads/edit.php?id=<?php echo $ad['id']; ?>" 
                                   class="btn btn-secondary">Edit</a>
                                
                                <form action="/views/ads/delete.php" method="post" class="delete-form" 
                                      onsubmit="return confirm('Are you sure you want to delete this advertisement?');">
                                    <input type="hidden" name="id" value="<?php echo $ad['id']; ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
$error = $result['error'] ?? '';
require_once __DIR__ . '/views/layouts/ad_layout.php';
?>
