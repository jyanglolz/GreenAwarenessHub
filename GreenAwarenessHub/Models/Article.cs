using System.ComponentModel.DataAnnotations;

namespace GreenAwarenessHub.Models
{
    public class Article
    {
        [Key]
        public int ArticleID { get; set; }

        
        public string ? Title { get; set; }

        
        public string ? Content { get; set; }

        
        public string  ? Author { get; set; }
    }
}
